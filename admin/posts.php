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
</head>
<body class="admin-body">

<?php
require_once 'auth.php';

$dataFile = dirname(__DIR__) . '/data/posts.json';

// ── Helper: load posts ──────────────────────────────────────────────────────
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

$action   = $_GET['action'] ?? 'list';
$editId   = isset($_GET['id']) ? (int)$_GET['id'] : null;
$feedback = '';
$feedbackType = 'success';

// ── HANDLE POST ACTIONS ────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $posts  = loadPosts($dataFile);
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

        if (empty($title)) {
            $feedback     = 'Title is required.';
            $feedbackType = 'error';
            $action = $id ? 'edit' : 'new';
            $editId = $id;
        } else {
            // Build slug from title
            $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-'));

            if ($id) {
                // Update existing
                foreach ($posts as &$p) {
                    if ((int)$p['id'] === $id) {
                        $p['title']     = $title;
                        $p['excerpt']   = $excerpt;
                        $p['body']      = $body;
                        $p['category']  = $category;
                        $p['date']      = $date;
                        $p['published'] = $published;
                        $p['slug']      = $slug;
                        break;
                    }
                }
                unset($p);
                $feedback = 'Post updated successfully.';
            } else {
                // Create new
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
                    'image'     => null,
                );
                $feedback = 'Post created successfully!';
            }
            savePosts($dataFile, $posts);
            $action = 'list';
        }
    }

    // ── Delete ──
    if ($pAction === 'delete') {
        $deleteId = (int)($_POST['id'] ?? 0);
        $posts    = array_filter($posts, function($p) use ($deleteId) {
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

// Find post being edited
$editPost = null;
if (($action === 'edit') && $editId) {
    foreach ($posts as $p) {
        if ((int)$p['id'] === $editId) { $editPost = $p; break; }
    }
    if (!$editPost) { $action = 'list'; }
}
?>

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

    <form method="POST" action="posts.php">
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
            <label class="admin-label" for="body">Post Body *</label>
            <textarea class="admin-textarea tall" id="body" name="body"
                      placeholder="Write your post here... You can use basic HTML like &lt;p&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;br&gt;"
                      ><?= htmlspecialchars($editPost['body'] ?? '') ?></textarea>
            <div class="admin-hint">
              Basic HTML is supported: &lt;p&gt;paragraph&lt;/p&gt;,
              &lt;strong&gt;bold&lt;/strong&gt;, &lt;em&gt;italic&lt;/em&gt;,
              &lt;br&gt; line break, &lt;a href=""&gt;link&lt;/a&gt;
            </div>
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
  // Update toggle label dynamically
  var toggle = document.getElementById('publishToggle');
  var label  = toggle ? toggle.closest('.toggle-wrap').querySelector('.toggle-label') : null;
  if (toggle && label) {
    toggle.addEventListener('change', function() {
      label.textContent = toggle.checked ? 'Published' : 'Draft';
    });
  }
</script>
</body>
</html>