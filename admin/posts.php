<?php
require_once 'auth.php';

$dataFile  = dirname(__DIR__) . '/data/posts.json';
$uploadDir = dirname(__DIR__) . '/assets/blog/';

// ── Helper: load posts ─────────────────────────────────────────────────────
function loadPosts($file) {
    if (!file_exists($file)) return array();
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? $data : array();
}

// ── Helper: save posts ─────────────────────────────────────────────────────
function savePosts($file, $posts) {
    return file_put_contents($file, json_encode(array_values($posts), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// ── Helper: next ID ────────────────────────────────────────────────────────
function nextId($posts) {
    $max = 0;
    foreach ($posts as $p) {
        if (!empty($p['id']) && (int)$p['id'] > $max) $max = (int)$p['id'];
    }
    return $max + 1;
}

// ── Helper: handle image upload ────────────────────────────────────────────
// Returns the web-relative path on success (e.g. "assets/blog/my-image.jpg"),
// null if no file was chosen, or false on error (sets $uploadError by ref).
function handleImageUpload($uploadDir, &$uploadError) {
    if (empty($_FILES['image']['name'])) return null; // no file chosen

    $allowed = array('image/jpeg', 'image/png');
    $maxSize = 4 * 1024 * 1024; // 4 MB

    $tmpPath  = $_FILES['image']['tmp_name'];
    $origName = $_FILES['image']['name'];
    $mimeType = $_FILES['image']['type'];
    $fileSize = $_FILES['image']['size'];
    $error    = $_FILES['image']['error'];

    if ($error !== UPLOAD_ERR_OK) {
        $uploadError = 'Upload failed (error code ' . $error . '). Please try again.';
        return false;
    }
    if (!in_array($mimeType, $allowed)) {
        $uploadError = 'Only JPG and PNG images are allowed.';
        return false;
    }
    // Double-check mime via file contents, not just browser-reported type
    $realMime = mime_content_type($tmpPath);
    if (!in_array($realMime, $allowed)) {
        $uploadError = 'File does not appear to be a valid JPG or PNG.';
        return false;
    }
    if ($fileSize > $maxSize) {
        $uploadError = 'Image must be under 4 MB.';
        return false;
    }

    // Create upload directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Build a safe unique filename
    $ext      = ($realMime === 'image/png') ? 'png' : 'jpg';
    $baseName = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', pathinfo($origName, PATHINFO_FILENAME)), '-'));
    $filename = $baseName . '-' . time() . '.' . $ext;
    $destPath = $uploadDir . $filename;

    if (!move_uploaded_file($tmpPath, $destPath)) {
        $uploadError = 'Could not save the uploaded file. Check folder permissions on assets/blog/.';
        return false;
    }

    return 'assets/blog/' . $filename; // web-relative path stored in JSON
}

$action       = $_GET['action'] ?? 'list';
$editId       = isset($_GET['id']) ? (int)$_GET['id'] : null;
$feedback     = '';
$feedbackType = 'success';

// ── HANDLE POST ACTIONS ────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $posts   = loadPosts($dataFile);
    $pAction = $_POST['_action'] ?? '';

    // ── Save (create or update) ──
    if ($pAction === 'save') {
        $id        = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $title     = trim($_POST['title']    ?? '');
        $excerpt   = trim($_POST['excerpt']  ?? '');
        $body      = trim($_POST['body']     ?? '');
        $category  = trim($_POST['category'] ?? '');
        $date      = trim($_POST['date']     ?? date('Y-m-d'));
        $published = isset($_POST['published']) && $_POST['published'] === '1';
        $removeImg = isset($_POST['remove_image']) && $_POST['remove_image'] === '1';

        if (empty($title)) {
            $feedback     = 'Title is required.';
            $feedbackType = 'error';
            $action = $id ? 'edit' : 'new';
            $editId = $id;
        } else {
            $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-'));

            // Handle image upload
            $uploadError = '';
            $newImagePath = handleImageUpload($uploadDir, $uploadError);

            if ($newImagePath === false) {
                // Upload attempted but failed
                $feedback     = $uploadError;
                $feedbackType = 'error';
                $action = $id ? 'edit' : 'new';
                $editId = $id;
            } else {
                if ($id) {
                    // Update existing post
                    foreach ($posts as &$p) {
                        if ((int)$p['id'] === $id) {
                            $p['title']     = $title;
                            $p['excerpt']   = $excerpt;
                            $p['body']      = $body;
                            $p['category']  = $category;
                            $p['date']      = $date;
                            $p['published'] = $published;
                            $p['slug']      = $slug;

                            if ($newImagePath !== null) {
                                // New image uploaded — delete old file if it exists
                                if (!empty($p['image'])) {
                                    $oldFile = dirname(__DIR__) . '/' . $p['image'];
                                    if (file_exists($oldFile)) @unlink($oldFile);
                                }
                                $p['image'] = $newImagePath;
                            } elseif ($removeImg) {
                                // Admin clicked "Remove image"
                                if (!empty($p['image'])) {
                                    $oldFile = dirname(__DIR__) . '/' . $p['image'];
                                    if (file_exists($oldFile)) @unlink($oldFile);
                                }
                                $p['image'] = null;
                            }
                            // If neither: keep existing image unchanged
                            break;
                        }
                    }
                    unset($p);
                    $feedback = 'Post updated successfully.';
                } else {
                    // Create new post
                    $posts[] = array(
                        'id'        => nextId($posts),
                        'slug'      => $slug,
                        'title'     => $title,
                        'excerpt'   => $excerpt,
                        'body'      => $body,
                        'category'  => $category,
                        'date'      => $date,
                        'published' => $published,
                        'author'    => 'Miracale Design',
                        'image'     => $newImagePath, // null if none uploaded
                    );
                    $feedback = 'Post created successfully!';
                }
                savePosts($dataFile, $posts);
                $action = 'list';
            }
        }
    }

    // ── Delete ──
    if ($pAction === 'delete') {
        $deleteId = (int)($_POST['id'] ?? 0);
        // Also delete the image file if one exists
        foreach ($posts as $p) {
            if ((int)$p['id'] === $deleteId && !empty($p['image'])) {
                $imgFile = dirname(__DIR__) . '/' . $p['image'];
                if (file_exists($imgFile)) @unlink($imgFile);
            }
        }
        $posts  = array_filter($posts, function($p) use ($deleteId) {
            return (int)$p['id'] !== $deleteId;
        });
        savePosts($dataFile, $posts);
        $feedback = 'Post deleted.';
        $action   = 'list';
    }
}

// ── Load for display ───────────────────────────────────────────────────────
$posts = loadPosts($dataFile);
usort($posts, function($a, $b) {
    return strcmp($b['date'] ?? '', $a['date'] ?? '');
});

$editPost = null;
if (($action === 'edit') && $editId) {
    foreach ($posts as $p) {
        if ((int)$p['id'] === $editId) { $editPost = $p; break; }
    }
    if (!$editPost) { $action = 'list'; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog Posts — Miracale Design Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styles.css" />
  <link rel="stylesheet" href="admin.css" />
  <style>
    /* ── Image upload field ── */
    .img-upload-area {
      border: 2px dashed rgba(28,26,23,0.15);
      border-radius: 12px;
      padding: 1.5rem;
      text-align: center;
      transition: border-color 0.2s, background 0.2s;
      cursor: pointer;
      position: relative;
    }
    .img-upload-area:hover { border-color: var(--green, #2D4A3E); background: rgba(45,74,62,0.03); }
    .img-upload-area input[type="file"] {
      position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .img-upload-icon { font-size: 2rem; margin-bottom: 0.4rem; }
    .img-upload-label {
      font-size: 0.82rem; font-weight: 600; color: var(--ink-soft, #4A4540);
    }
    .img-upload-hint { font-size: 0.74rem; color: var(--ink-soft, #4A4540); opacity: 0.6; margin-top: 0.25rem; }

    /* Preview of current or newly chosen image */
    .img-preview-wrap {
      position: relative; display: inline-block;
      margin-top: 0.8rem; border-radius: 10px; overflow: hidden;
      box-shadow: 0 4px 16px rgba(28,26,23,0.12);
    }
    .img-preview-wrap img {
      display: block; max-height: 180px; max-width: 100%; object-fit: cover; border-radius: 10px;
    }
    .img-preview-filename {
      font-size: 0.75rem; color: var(--ink-soft, #4A4540); margin-top: 0.4rem; font-style: italic;
    }

    /* Remove image checkbox row */
    .remove-img-row {
      display: flex; align-items: center; gap: 0.5rem;
      margin-top: 0.7rem; font-size: 0.8rem; color: var(--terra, #C9683A); cursor: pointer;
    }
    .remove-img-row input { cursor: pointer; accent-color: var(--terra, #C9683A); }
  </style>
</head>
<body class="admin-body">

<?php include 'admin-nav.php'; ?>

<main class="admin-main">
  <div class="admin-container">

    <!-- Feedback -->
    <?php if ($feedback): ?>
      <div class="admin-feedback show <?= $feedbackType ?>">
        <?= htmlspecialchars($feedback) ?>
      </div>
    <?php endif; ?>

    <?php if ($action === 'list'): ?>
    <!-- ══ LIST VIEW ══ -->
    <div class="admin-page-header">
      <div>
        <h1 class="admin-page-title">Blog Posts</h1>
        <p class="admin-page-sub"><?= count($posts) ?> post<?= count($posts) !== 1 ? 's' : '' ?> total</p>
      </div>
      <a href="?action=new" class="admin-btn admin-btn-primary">+ New Post</a>
    </div>

    <?php if (empty($posts)): ?>
      <div class="admin-empty">
        <div class="admin-empty-icon">✏️</div>
        <p>No posts yet. <a href="?action=new">Write your first post →</a></p>
      </div>
    <?php else: ?>
      <div class="admin-table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Title</th>
              <th>Category</th>
              <th>Date</th>
              <th>Image</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($posts as $post): ?>
            <tr>
              <td class="td-title"><?= htmlspecialchars($post['title']) ?></td>
              <td><?= htmlspecialchars($post['category'] ?? '—') ?></td>
              <td><?= htmlspecialchars($post['date'] ?? '—') ?></td>
              <td>
                <?php if (!empty($post['image'])): ?>
                  <img src="../<?= htmlspecialchars($post['image']) ?>"
                       alt="thumbnail"
                       style="height:36px; width:54px; object-fit:cover; border-radius:5px; display:block;" />
                <?php else: ?>
                  <span style="font-size:1.1rem; opacity:0.4;">✍️</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if (!empty($post['published'])): ?>
                  <span class="badge badge-green">Published</span>
                <?php else: ?>
                  <span class="badge badge-grey">Draft</span>
                <?php endif; ?>
              </td>
              <td>
                <a href="?action=edit&id=<?= (int)$post['id'] ?>" class="admin-table-link">Edit</a>
                <form method="POST" style="display:inline"
                      onsubmit="return confirm('Delete this post? This cannot be undone.')">
                  <input type="hidden" name="_action" value="delete" />
                  <input type="hidden" name="id" value="<?= (int)$post['id'] ?>" />
                  <button type="submit" class="admin-table-link danger"
                          style="background:none;border:none;cursor:pointer;padding:0;font-size:inherit;font-family:inherit">
                    Delete
                  </button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

    <?php else: ?>
    <!-- ══ NEW / EDIT FORM ══ -->
    <div class="admin-page-header">
      <div>
        <h1 class="admin-page-title">
          <?= $action === 'edit' ? 'Edit Post' : 'New Blog Post' ?>
        </h1>
      </div>
      <a href="?action=list" class="admin-btn admin-btn-ghost">← Back to Posts</a>
    </div>

    <!-- enctype required for file uploads -->
    <form method="POST" action="posts.php" enctype="multipart/form-data">
      <input type="hidden" name="_action" value="save" />
      <?php if ($editPost): ?>
        <input type="hidden" name="id" value="<?= (int)$editPost['id'] ?>" />
      <?php endif; ?>

      <div class="admin-form-card">
        <h3>Post Content</h3>

        <div class="admin-form-row full">
          <div class="admin-form-group">
            <label class="admin-label" for="title">Title *</label>
            <input class="admin-input" type="text" id="title" name="title"
                   placeholder="Give your post a title..."
                   value="<?= htmlspecialchars($editPost['title'] ?? '') ?>" required />
          </div>
        </div>

        <div class="admin-form-row full">
          <div class="admin-form-group">
            <label class="admin-label" for="excerpt">Excerpt</label>
            <input class="admin-input" type="text" id="excerpt" name="excerpt"
                   placeholder="A short summary shown on the blog page..."
                   value="<?= htmlspecialchars($editPost['excerpt'] ?? '') ?>" />
            <div class="admin-hint">Keep it under 160 characters. Shows under the post title on the blog page.</div>
          </div>
        </div>

        <div class="admin-form-row full">
          <div class="admin-form-group">
            <label class="admin-label" for="body">Post Body</label>
            <textarea class="admin-textarea tall" id="body" name="body"
                      placeholder="Write your post here... You can use basic HTML like &lt;p&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;br&gt;"
                      ><?= htmlspecialchars($editPost['body'] ?? '') ?></textarea>
            <div class="admin-hint">
              Basic HTML supported: &lt;p&gt;paragraph&lt;/p&gt;,
              &lt;strong&gt;bold&lt;/strong&gt;, &lt;em&gt;italic&lt;/em&gt;,
              &lt;br&gt; line break, &lt;a href=""&gt;link&lt;/a&gt;
            </div>
          </div>
        </div>
      </div>

      <div class="admin-form-card">
        <h3>Cover Image <span style="font-weight:400; font-size:0.8rem; color:var(--ink-soft); opacity:0.7;">(optional)</span></h3>

        <?php $currentImage = $editPost['image'] ?? null; ?>

        <?php if ($currentImage): ?>
          <!-- Existing image preview -->
          <div style="margin-bottom:1rem;">
            <div class="admin-label" style="margin-bottom:0.5rem;">Current image</div>
            <div class="img-preview-wrap">
              <img src="../<?= htmlspecialchars($currentImage) ?>"
                   alt="Current cover image" />
            </div>
            <!-- Option to remove current image -->
            <label class="remove-img-row">
              <input type="checkbox" name="remove_image" value="1" id="removeImage" />
              Remove current image (post will show the ✍️ placeholder instead)
            </label>
          </div>
          <div class="admin-label" style="margin-bottom:0.5rem;">Replace with a new image</div>
        <?php else: ?>
          <div class="admin-label" style="margin-bottom:0.5rem;">Upload an image</div>
        <?php endif; ?>

        <!-- Upload area -->
        <div class="img-upload-area" id="uploadArea">
          <input type="file" name="image" id="imageInput"
                 accept="image/jpeg,image/png" />
          <div class="img-upload-icon">🖼️</div>
          <div class="img-upload-label">
            <?= $currentImage ? 'Click to choose a replacement image' : 'Click to choose an image' ?>
          </div>
          <div class="img-upload-hint">JPG or PNG · max 4 MB</div>
          <!-- Live preview of newly selected file -->
          <div id="newPreview" style="display:none; margin-top:0.8rem;">
            <img id="newPreviewImg" src="" alt="Preview"
                 style="max-height:160px; border-radius:8px; object-fit:cover;" />
            <div class="img-preview-filename" id="newPreviewName"></div>
          </div>
        </div>

      </div>

      <div class="admin-form-card">
        <h3>Post Details</h3>
        <div class="admin-form-row">
          <div class="admin-form-group">
            <label class="admin-label" for="category">Category</label>
            <select class="admin-select" id="category" name="category">
              <?php
                $cats = array('Updates', 'Process', 'Events', 'New Work', 'Behind the Scenes', 'Other');
                $currentCat = $editPost['category'] ?? '';
                foreach ($cats as $cat):
              ?>
                <option value="<?= $cat ?>"
                  <?= $currentCat === $cat ? 'selected' : '' ?>
                ><?= $cat ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="admin-form-group">
            <label class="admin-label" for="date">Date</label>
            <input class="admin-input" type="date" id="date" name="date"
                   value="<?= htmlspecialchars($editPost['date'] ?? date('Y-m-d')) ?>" />
          </div>
        </div>

        <div class="publish-row">
          <label class="toggle-wrap">
            <span class="toggle-label">
              <?php $isPublished = !empty($editPost['published']); ?>
              <?= $editPost ? ($isPublished ? 'Published' : 'Draft') : 'Publish immediately?' ?>
            </span>
            <label class="toggle-switch">
              <input type="checkbox" name="published" value="1"
                     id="publishToggle"
                     <?= (!$editPost || $isPublished) ? 'checked' : '' ?> />
              <span class="toggle-slider"></span>
            </label>
          </label>
          <button type="submit" class="admin-btn admin-btn-primary">
            <?= $action === 'edit' ? 'Save Changes' : 'Create Post' ?>
          </button>
        </div>
      </div>

    </form>
    <?php endif; ?>

  </div>
</main>

<script>
  // ── Publish toggle label ──
  var toggle = document.getElementById('publishToggle');
  var label  = toggle ? toggle.closest('.toggle-wrap').querySelector('.toggle-label') : null;
  if (toggle && label) {
    toggle.addEventListener('change', function() {
      label.textContent = toggle.checked ? 'Published' : 'Draft';
    });
  }

  // ── Image file picker: live preview ──
  var imageInput  = document.getElementById('imageInput');
  var newPreview  = document.getElementById('newPreview');
  var previewImg  = document.getElementById('newPreviewImg');
  var previewName = document.getElementById('newPreviewName');
  var removeChk   = document.getElementById('removeImage');

  if (imageInput) {
    imageInput.addEventListener('change', function() {
      var file = imageInput.files[0];
      if (!file) { newPreview.style.display = 'none'; return; }

      var reader = new FileReader();
      reader.onload = function(e) {
        previewImg.src      = e.target.result;
        previewName.textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
        newPreview.style.display = 'block';
      };
      reader.readAsDataURL(file);

      // If a new image is chosen, uncheck "remove" — they're mutually exclusive
      if (removeChk) removeChk.checked = false;
    });
  }

  // If "remove image" is checked, clear any chosen file
  if (removeChk) {
    removeChk.addEventListener('change', function() {
      if (removeChk.checked && imageInput) {
        imageInput.value = '';
        newPreview.style.display = 'none';
      }
    });
  }
</script>
</body>
</html>