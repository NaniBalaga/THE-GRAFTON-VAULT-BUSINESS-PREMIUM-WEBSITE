<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json');

session_start();
include 'db.php';

$target_dir = "uploads/";
if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

// =================================================================================
// 1. DELETE ACTIONS
// =================================================================================

// Delete Single Collection Gallery Image
if (isset($_POST['action']) && $_POST['action'] === 'delete_collection_image') {
    $id = intval($_POST['id']);
    $res = $conn->query("SELECT image_path FROM collection_gallery WHERE id=$id");
    if($res && $row = $res->fetch_assoc()) {
        if(!empty($row['image_path']) && file_exists($row['image_path'])) unlink($row['image_path']);
    }
    if($conn->query("DELETE FROM collection_gallery WHERE id=$id")) {
        echo json_encode(['status' => 'success', 'message' => 'Image deleted']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
    exit();
}

// Generic Delete
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = intval($_POST['id']);
    $type = $_POST['type'];
    
    $table_map = [
        'collection' => 'collections', 'review' => 'reviews', 'message' => 'contact_submissions',
        'blog' => 'blog_posts', 'insta' => 'instagram_posts', 'service' => 'services',
        'faq' => 'faqs', 'gallery' => 'shop_gallery'
    ];

    if (!isset($table_map[$type])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid type']);
        exit;
    }

    $table = $table_map[$type];

    // Delete image file if applicable
    if (in_array($type, ['collection', 'blog', 'insta', 'service', 'gallery'])) {
        $col = ($type === 'insta' || $type === 'gallery') ? 'image_url' : (($type === 'service') ? 'icon_image' : 'cover_image');
        $res = $conn->query("SELECT $col FROM $table WHERE id=$id");
        if ($res && $row = $res->fetch_assoc()) {
            if (!empty($row[$col]) && file_exists($row[$col])) unlink($row[$col]);
        }
    }
    
    // If collection, delete associated gallery images too
    if ($type === 'collection') {
         $res = $conn->query("SELECT image_path FROM collection_gallery WHERE collection_id=$id");
         while($row = $res->fetch_assoc()) {
             if(!empty($row['image_path']) && file_exists($row['image_path'])) unlink($row['image_path']);
         }
         $conn->query("DELETE FROM collection_gallery WHERE collection_id=$id");
    }

    if ($conn->query("DELETE FROM $table WHERE id=$id")) {
        echo json_encode(['status' => 'success', 'message' => ucfirst($type) . ' deleted.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
    exit();
}

// =================================================================================
// 2. FETCH ACTIONS
// =================================================================================
if (isset($_POST['action']) && $_POST['action'] === 'get_collection_gallery') {
    $id = intval($_POST['id']);
    $res = $conn->query("SELECT * FROM collection_gallery WHERE collection_id=$id ORDER BY id DESC");
    $data = [];
    while($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(['status' => 'success', 'data' => $data]);
    exit();
}


// =================================================================================
// 3. FORM SUBMISSIONS
// =================================================================================

// --- BANNER SETTINGS ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_banner'])) {
    $text = $conn->real_escape_string($_POST['banner_text']);
    $url = $conn->real_escape_string($_POST['banner_url']);
    $active = isset($_POST['banner_active']) ? 1 : 0;
    
    $check = $conn->query("SELECT id FROM banners LIMIT 1");
    if ($check->num_rows > 0) {
        $sql = "UPDATE banners SET text='$text', url='$url', is_active='$active' LIMIT 1";
    } else {
        $sql = "INSERT INTO banners (text, url, is_active) VALUES ('$text', '$url', '$active')";
    }
    
    if ($conn->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Banner updated!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
    exit();
}

// --- UPDATE BOOKING LINK (Global Site Setting) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_booking_link'])) {
    $url = $conn->real_escape_string($_POST['booking_url']);
    
    $check = $conn->query("SELECT id FROM site_settings WHERE setting_key = 'service_booking_url'");
    
    if ($check->num_rows > 0) {
        $sql = "UPDATE site_settings SET setting_value = '$url' WHERE setting_key = 'service_booking_url'";
    } else {
        $sql = "INSERT INTO site_settings (setting_key, setting_value) VALUES ('service_booking_url', '$url')";
    }
    
    if ($conn->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Global Booking Link Updated!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database Error']);
    }
    exit();
}

// --- FAQs ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_faq'])) {
    $question = $conn->real_escape_string($_POST['question']);
    $answer = $conn->real_escape_string($_POST['answer']);
    $id = isset($_POST['faq_id']) ? intval($_POST['faq_id']) : null;
    $action = $_POST['action_faq'];

    if ($action == 'update') {
        $sql = "UPDATE faqs SET question='$question', answer='$answer' WHERE id=$id";
        $msg = 'FAQ updated!';
    } else {
        $sql = "INSERT INTO faqs (question, answer) VALUES ('$question', '$answer')";
        $msg = 'FAQ added!';
    }

    if ($conn->query($sql)) {
        if($action == 'add') $id = $conn->insert_id;
        echo json_encode(['status' => 'success', 'message' => $msg, 'type'=>'faq', 'action'=>$action, 'data'=>['id'=>$id, 'question'=>$question, 'answer'=>$answer]]);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
    exit();
}

// --- SHOP GALLERY (With Multiple Upload) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_gallery'])) {
    $uploaded_images = [];
    
    // Check if multiple files were uploaded
    if (isset($_FILES['gallery_images']) && is_array($_FILES['gallery_images']['name'])) {
        $count = count($_FILES['gallery_images']['name']);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($_FILES['gallery_images']['name'][$i])) {
                $name = time() . "_shop_" . $i . "_" . basename($_FILES['gallery_images']['name'][$i]);
                if (move_uploaded_file($_FILES['gallery_images']['tmp_name'][$i], $target_dir . $name)) {
                    $path = $target_dir . $name;
                    $sql = "INSERT INTO shop_gallery (image_url) VALUES ('$path')";
                    if ($conn->query($sql)) {
                        $id = $conn->insert_id;
                        $uploaded_images[] = ['id' => $id, 'image_url' => $path];
                    }
                }
            }
        }
    } 
    // Fallback for single file input named 'gallery_image' (old compatibility)
    elseif (!empty($_FILES["gallery_image"]["name"])) {
        $name = time() . "_shop_" . basename($_FILES["gallery_image"]["name"]);
        if (move_uploaded_file($_FILES["gallery_image"]["tmp_name"], $target_dir . $name)) {
            $path = $target_dir . $name;
            $sql = "INSERT INTO shop_gallery (image_url) VALUES ('$path')";
            if ($conn->query($sql)) {
                $id = $conn->insert_id;
                $uploaded_images = ['id' => $id, 'image_url' => $path];
            }
        }
    }

    if (!empty($uploaded_images)) {
        echo json_encode(['status' => 'success', 'message' => 'Image(s) added!', 'type'=>'gallery', 'action'=>'add', 'data'=>$uploaded_images]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No valid images selected.']);
    }
    exit();
}

// --- SERVICES (UPDATED WITH URL & BUTTON TEXT) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_service'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $desc = $conn->real_escape_string($_POST['description']);
    
    // Retrieve new fields, default button text if empty
    $b_url = isset($_POST['booking_url']) ? $conn->real_escape_string($_POST['booking_url']) : '';
    $b_text = isset($_POST['button_text']) && !empty($_POST['button_text']) ? $conn->real_escape_string($_POST['button_text']) : 'Book Now';

    $id = isset($_POST['service_id']) ? intval($_POST['service_id']) : null;
    $action = $_POST['action_service'];
    $final_path = "";

    if (!empty($_FILES["service_image"]["name"])) {
        $name = time() . "_serv_" . basename($_FILES["service_image"]["name"]);
        if (move_uploaded_file($_FILES["service_image"]["tmp_name"], $target_dir . $name)) {
            $final_path = $target_dir . $name;
        }
    }

    if ($action == 'update') {
        // Update query including new columns
        $sql = "UPDATE services SET title='$title', description='$desc', booking_url='$b_url', button_text='$b_text'";
        if ($final_path) $sql .= ", icon_image='$final_path'";
        $sql .= " WHERE id=$id";
        
        if ($conn->query($sql)) {
            if(!$final_path) {
                $res = $conn->query("SELECT icon_image FROM services WHERE id=$id");
                $final_path = $res->fetch_assoc()['icon_image'];
            }
            // Return new fields in JSON so frontend can update if needed
            echo json_encode(['status' => 'success', 'message' => 'Service updated!', 'type' => 'service', 'action' => 'update', 'data' => ['id'=>$id, 'title'=>$title, 'description'=>$desc, 'booking_url'=>$b_url, 'button_text'=>$b_text, 'icon_image'=>$final_path]]);
        }
    } else {
        if ($final_path) {
            // Insert query including new columns
            $sql = "INSERT INTO services (title, description, icon_image, booking_url, button_text) VALUES ('$title', '$desc', '$final_path', '$b_url', '$b_text')";
            if ($conn->query($sql)) {
                $id = $conn->insert_id;
                echo json_encode(['status' => 'success', 'message' => 'Service added!', 'type' => 'service', 'action' => 'add', 'data' => ['id'=>$id, 'title'=>$title, 'description'=>$desc, 'booking_url'=>$b_url, 'button_text'=>$b_text, 'icon_image'=>$final_path]]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Image required.']);
        }
    }
    exit();
}

// --- BLOG ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_blog'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $subtitle = $conn->real_escape_string($_POST['subtitle']);
    $content = $conn->real_escape_string($_POST['content']);
    $id = isset($_POST['blog_id']) ? intval($_POST['blog_id']) : null;
    $action = $_POST['action_blog'];
    $final_path = "";

    if (!empty($_FILES["cover_image"]["name"])) {
        $name = time() . "_blog_" . basename($_FILES["cover_image"]["name"]);
        if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_dir . $name)) {
            $final_path = $target_dir . $name;
        }
    }

    if ($action == 'update') {
        $sql = "UPDATE blog_posts SET title='$title', subtitle='$subtitle', content='$content'";
        if ($final_path) $sql .= ", cover_image='$final_path'";
        $sql .= " WHERE id=$id";
        if ($conn->query($sql)) {
            if(!$final_path) {
                $res = $conn->query("SELECT cover_image FROM blog_posts WHERE id=$id");
                $final_path = $res->fetch_assoc()['cover_image'];
            }
            echo json_encode(['status' => 'success', 'message' => 'Blog updated!', 'type' => 'blog', 'action' => 'update', 'data' => ['id'=>$id, 'title'=>$title, 'subtitle'=>$subtitle, 'cover_image'=>$final_path, 'created_at'=>date('M d, Y')]]);
        }
    } else {
        if ($final_path) {
            $sql = "INSERT INTO blog_posts (title, subtitle, content, cover_image) VALUES ('$title', '$subtitle', '$content', '$final_path')";
            if ($conn->query($sql)) {
                $id = $conn->insert_id;
                echo json_encode(['status' => 'success', 'message' => 'Blog published!', 'type' => 'blog', 'action' => 'add', 'data' => ['id'=>$id, 'title'=>$title, 'subtitle'=>$subtitle, 'cover_image'=>$final_path, 'created_at'=>date('M d, Y')]]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Cover image required.']);
        }
    }
    exit();
}

// --- INSTAGRAM ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_insta'])) {
    $caption = $conn->real_escape_string($_POST['caption']);
    $url = $conn->real_escape_string($_POST['post_url']);
    $id = isset($_POST['insta_id']) ? intval($_POST['insta_id']) : null;
    $action = $_POST['action_insta'];
    $final_path = "";

    if (!empty($_FILES["insta_image"]["name"])) {
        $name = time() . "_insta_" . basename($_FILES["insta_image"]["name"]);
        if (move_uploaded_file($_FILES["insta_image"]["tmp_name"], $target_dir . $name)) {
            $final_path = $target_dir . $name;
        }
    }

    if ($action == 'update') {
        $sql = "UPDATE instagram_posts SET caption='$caption', post_url='$url'";
        if ($final_path) $sql .= ", image_url='$final_path'";
        $sql .= " WHERE id=$id";
        if ($conn->query($sql)) {
             if(!$final_path) {
                $res = $conn->query("SELECT image_url FROM instagram_posts WHERE id=$id");
                $final_path = $res->fetch_assoc()['image_url'];
            }
            echo json_encode(['status' => 'success', 'message' => 'Post updated!', 'type' => 'insta', 'action' => 'update', 'data' => ['id'=>$id, 'caption'=>$caption, 'post_url'=>$url, 'image_url'=>$final_path]]);
        }
    } else {
        if ($final_path) {
            $sql = "INSERT INTO instagram_posts (caption, post_url, image_url) VALUES ('$caption', '$url', '$final_path')";
            if ($conn->query($sql)) {
                $id = $conn->insert_id;
                echo json_encode(['status' => 'success', 'message' => 'Post added!', 'type' => 'insta', 'action' => 'add', 'data' => ['id'=>$id, 'caption'=>$caption, 'post_url'=>$url, 'image_url'=>$final_path]]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Image required.']);
        }
    }
    exit();
}

// --- COLLECTIONS ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_collection'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $calendly_link = $conn->real_escape_string($_POST['calendly_link']);
    $id = isset($_POST['collection_id']) ? intval($_POST['collection_id']) : null;
    $action = $_POST['action_collection'];
    $remove_cover = isset($_POST['remove_cover_image']) && $_POST['remove_cover_image'] === 'true';
    $final_cover_path = "";

    // 1. Handle Cover Image
    if (!empty($_FILES["cover_image"]["name"])) {
        $cover_name = time() . "_cover_" . basename($_FILES["cover_image"]["name"]);
        if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_dir . $cover_name)) {
            $final_cover_path = $target_dir . $cover_name;
        }
    }

    if ($action == 'update') {
        $sql = "UPDATE collections SET title='$title', description='$description', calendly_link='$calendly_link'";
        if ($final_cover_path) $sql .= ", cover_image='$final_cover_path'";
        elseif ($remove_cover) { $sql .= ", cover_image=''"; $final_cover_path = ""; }
        $sql .= " WHERE id=$id";

        if ($conn->query($sql)) {
            if (!$final_cover_path && !$remove_cover) {
                $res = $conn->query("SELECT cover_image FROM collections WHERE id=$id");
                $data = $res->fetch_assoc();
                $final_cover_path = $data ? $data['cover_image'] : '';
            }
            // 2. Handle New Gallery Images for UPDATE
            if (!empty($_FILES['gallery_images']['name'][0])) {
                foreach($_FILES['gallery_images']['tmp_name'] as $key => $tmp_name) {
                    if (!empty($tmp_name)) {
                        $g_name = time() . "_" . $key . "_" . basename($_FILES['gallery_images']['name'][$key]);
                        if(move_uploaded_file($tmp_name, $target_dir . $g_name)) {
                            $conn->query("INSERT INTO collection_gallery (collection_id, image_path) VALUES ('$id', '" . $target_dir . $g_name . "')");
                        }
                    }
                }
            }
            echo json_encode(['status' => 'success', 'message' => 'Collection updated!', 'type' => 'collection', 'action' => 'update', 'data' => ['id' => $id, 'title' => $title, 'description' => $description, 'calendly_link' => $calendly_link, 'cover_image' => $final_cover_path]]);
        }
    } else {
        if ($final_cover_path) {
            $sql = "INSERT INTO collections (title, description, cover_image, calendly_link) VALUES ('$title', '$description', '$final_cover_path', '$calendly_link')";
            if ($conn->query($sql)) {
                $id = $conn->insert_id;
                // 3. Handle Gallery Images for INSERT
                if (!empty($_FILES['gallery_images']['name'][0])) {
                    foreach($_FILES['gallery_images']['tmp_name'] as $key => $tmp_name) {
                        if (!empty($tmp_name)) {
                            $g_name = time() . "_" . $key . "_" . basename($_FILES['gallery_images']['name'][$key]);
                            if(move_uploaded_file($tmp_name, $target_dir . $g_name)) {
                                $conn->query("INSERT INTO collection_gallery (collection_id, image_path) VALUES ('$id', '" . $target_dir . $g_name . "')");
                            }
                        }
                    }
                }
                echo json_encode(['status' => 'success', 'message' => 'Collection created!', 'type' => 'collection', 'action' => 'add', 'data' => ['id' => $id, 'title' => $title, 'description' => $description, 'calendly_link' => $calendly_link, 'cover_image' => $final_cover_path]]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Cover image required.']);
        }
    }
    exit();
}

// --- REVIEWS ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_review'])) {
    $r_name = $conn->real_escape_string($_POST['reviewer_name']);
    $r_initial = strtoupper(substr($r_name, 0, 1)); 
    $r_text = $conn->real_escape_string($_POST['review_text']);
    $r_date = $conn->real_escape_string($_POST['date_posted']);
    $r_rating = intval($_POST['rating']);
    $r_id = isset($_POST['review_id']) ? intval($_POST['review_id']) : null;
    $action = $_POST['action_review'];

    if ($action == 'update') {
        $sql = "UPDATE reviews SET reviewer_name='$r_name', reviewer_initial='$r_initial', review_text='$r_text', date_posted='$r_date', rating='$r_rating' WHERE id=$r_id";
        if($conn->query($sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Review updated!', 'type' => 'review', 'action' => 'update', 'data' => ['id' => $r_id, 'reviewer_name' => $r_name, 'reviewer_initial' => $r_initial, 'review_text' => $r_text, 'date_posted' => $r_date, 'rating' => $r_rating]]);
        }
    } else {
        $sql = "INSERT INTO reviews (reviewer_name, reviewer_initial, review_text, date_posted, rating) VALUES ('$r_name', '$r_initial', '$r_text', '$r_date', '$r_rating')";
        if($conn->query($sql)) {
            $r_id = $conn->insert_id;
            echo json_encode(['status' => 'success', 'message' => 'Review added!', 'type' => 'review', 'action' => 'add', 'data' => ['id' => $r_id, 'reviewer_name' => $r_name, 'reviewer_initial' => $r_initial, 'review_text' => $r_text, 'date_posted' => $r_date, 'rating' => $r_rating]]);
        }
    }
    exit();
}
?>