<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Events — Miracale Design Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styles.css" />
  <link rel="stylesheet" href="admin.css" />
</head>
<body class="admin-body">

<?php
require_once 'auth.php';

$dataFile = dirname(__DIR__) . '/data/events.json';

function loadEvents($file) {
    if (!file_exists($file)) return array();
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? $data : array();
}

function saveEvents($file, $events) {
    return file_put_contents($file, json_encode(array_values($events), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function nextEventId($events) {
    $max = 0;
    foreach ($events as $e) {
        if (!empty($e['id']) && (int)$e['id'] > $max) $max = (int)$e['id'];
    }
    return $max + 1;
}

$action       = $_GET['action'] ?? 'list';
$editId       = isset($_GET['id']) ? (int)$_GET['id'] : null;
$feedback     = '';
$feedbackType = 'success';

// ── HANDLE POST ────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $events  = loadEvents($dataFile);
    $pAction = $_POST['_action'] ?? '';

    if ($pAction === 'save') {
        $id          = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $title       = trim($_POST['title']       ?? '');
        $date        = trim($_POST['date']        ?? '');
        $endDate     = trim($_POST['end_date']    ?? '');
        $location    = trim($_POST['location']    ?? '');
        $venue       = trim($_POST['venue']       ?? '');
        $address     = trim($_POST['address']     ?? '');
        $description = trim($_POST['description'] ?? '');
        $link        = trim($_POST['link']        ?? '');

        if (empty($title) || empty($date)) {
            $feedback     = 'Title and date are required.';
            $feedbackType = 'error';
            $action = $id ? 'edit' : 'new';
            $editId = $id;
        } else {
            $eventData = array(
                'title'       => $title,
                'date'        => $date,
                'end_date'    => $endDate ?: null,
                'location'    => $location,
                'venue'       => $venue,
                'address'     => $address,
                'description' => $description,
                'link'        => $link ?: null,
            );

            if ($id) {
                foreach ($events as &$e) {
                    if ((int)$e['id'] === $id) {
                        $e = array_merge($e, $eventData);
                        break;
                    }
                }
                unset($e);
                $feedback = 'Event updated.';
            } else {
                $eventData['id'] = nextEventId($events);
                $events[]        = $eventData;
                $feedback        = 'Event added!';
            }
            saveEvents($dataFile, $events);
            $action = 'list';
        }
    }

    if ($pAction === 'delete') {
        $deleteId = (int)($_POST['id'] ?? 0);
        $events   = array_filter($events, function($e) use ($deleteId) {
            return (int)$e['id'] !== $deleteId;
        });
        saveEvents($dataFile, $events);
        $feedback = 'Event deleted.';
        $action   = 'list';
    }
}

// ── Load ───────────────────────────────────────────────────────────────────
$events = loadEvents($dataFile);
usort($events, function($a, $b) {
    return strcmp($a['date'] ?? '', $b['date'] ?? '');
});

$today       = date('Y-m-d');
$editEvent   = null;

if ($action === 'edit' && $editId) {
    foreach ($events as $e) {
        if ((int)$e['id'] === $editId) { $editEvent = $e; break; }
    }
    if (!$editEvent) $action = 'list';
}
?>

<?php include 'admin-nav.php'; ?>

<main class="admin-main">
  <div class="admin-container">

    <?php if ($feedback): ?>
      <div class="admin-feedback show <?= $feedbackType ?>">
        <?= htmlspecialchars($feedback) ?>
      </div>
    <?php endif; ?>

    <?php if ($action === 'list'): ?>
    <!-- ══ LIST ══ -->
    <div class="admin-page-header">
      <div>
        <h1 class="admin-page-title">Events</h1>
        <p class="admin-page-sub"><?= count($events) ?> event<?= count($events) !== 1 ? 's' : '' ?> total</p>
      </div>
      <a href="?action=new" class="admin-btn admin-btn-primary">+ Add Event</a>
    </div>

    <?php if (empty($events)): ?>
      <div class="admin-empty">
        <div class="admin-empty-icon">📅</div>
        <p>No events yet. <a href="?action=new">Add your first event →</a></p>
      </div>
    <?php else: ?>
      <div class="admin-table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Event</th>
              <th>Date</th>
              <th>Location</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($events as $event): ?>
            <tr>
              <td class="td-title"><?= htmlspecialchars($event['title']) ?></td>
              <td>
                <?= htmlspecialchars($event['date'] ?? '—') ?>
                <?php if (!empty($event['end_date'])): ?>
                  <span style="font-size:0.72rem; color:var(--ink-soft)">
                    → <?= htmlspecialchars($event['end_date']) ?>
                  </span>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($event['location'] ?? '—') ?></td>
              <td>
                <?php if (!empty($event['date']) && $event['date'] >= $today): ?>
                  <span class="badge badge-green">Upcoming</span>
                <?php else: ?>
                  <span class="badge badge-grey">Past</span>
                <?php endif; ?>
              </td>
              <td>
                <a href="?action=edit&id=<?= (int)$event['id'] ?>" class="admin-table-link">Edit</a>
                <form method="POST" style="display:inline"
                      onsubmit="return confirm('Delete this event?')">
                  <input type="hidden" name="_action" value="delete" />
                  <input type="hidden" name="id" value="<?= (int)$event['id'] ?>" />
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
          <?= $action === 'edit' ? 'Edit Event' : 'Add Event' ?>
        </h1>
      </div>
      <a href="?action=list" class="admin-btn admin-btn-ghost">← Back to Events</a>
    </div>

    <form method="POST" action="events.php">
      <input type="hidden" name="_action" value="save" />
      <?php if ($editEvent): ?>
        <input type="hidden" name="id" value="<?= (int)$editEvent['id'] ?>" />
      <?php endif; ?>

      <div class="admin-form-card">
        <h3>Event Details</h3>

        <div class="admin-form-row full">
          <div class="admin-form-group">
            <label class="admin-label" for="title">Event Name *</label>
            <input class="admin-input" type="text" id="title" name="title"
                   placeholder="e.g. Shenandoah Valley Craft Fair"
                   value="<?= htmlspecialchars($editEvent['title'] ?? '') ?>" required />
          </div>
        </div>

        <div class="admin-form-row">
          <div class="admin-form-group">
            <label class="admin-label" for="date">Start Date *</label>
            <input class="admin-input" type="date" id="date" name="date"
                   value="<?= htmlspecialchars($editEvent['date'] ?? '') ?>" required />
          </div>
          <div class="admin-form-group">
            <label class="admin-label" for="end_date">End Date</label>
            <input class="admin-input" type="date" id="end_date" name="end_date"
                   value="<?= htmlspecialchars($editEvent['end_date'] ?? '') ?>" />
            <div class="admin-hint">Leave blank for single-day events.</div>
          </div>
        </div>

        <div class="admin-form-row">
          <div class="admin-form-group">
            <label class="admin-label" for="location">City / Location *</label>
            <input class="admin-input" type="text" id="location" name="location"
                   placeholder="e.g. Harrisonburg, VA"
                   value="<?= htmlspecialchars($editEvent['location'] ?? '') ?>" />
          </div>
          <div class="admin-form-group">
            <label class="admin-label" for="venue">Venue Name</label>
            <input class="admin-input" type="text" id="venue" name="venue"
                   placeholder="e.g. Rockingham County Fairgrounds"
                   value="<?= htmlspecialchars($editEvent['venue'] ?? '') ?>" />
          </div>
        </div>

        <div class="admin-form-row full">
          <div class="admin-form-group">
            <label class="admin-label" for="address">Full Address</label>
            <input class="admin-input" type="text" id="address" name="address"
                   placeholder="e.g. 4808 S Valley Pike, Harrisonburg, VA 22801"
                   value="<?= htmlspecialchars($editEvent['address'] ?? '') ?>" />
          </div>
        </div>

        <div class="admin-form-row full">
          <div class="admin-form-group">
            <label class="admin-label" for="description">Description</label>
            <textarea class="admin-textarea" id="description" name="description"
                      placeholder="Tell visitors what to expect — booth number, what you'll be bringing, etc."
                      ><?= htmlspecialchars($editEvent['description'] ?? '') ?></textarea>
          </div>
        </div>

        <div class="admin-form-row full">
          <div class="admin-form-group">
            <label class="admin-label" for="link">Event Link</label>
            <input class="admin-input" type="url" id="link" name="link"
                   placeholder="https://eventwebsite.com (optional)"
                   value="<?= htmlspecialchars($editEvent['link'] ?? '') ?>" />
            <div class="admin-hint">Optional external link to the event's website or Facebook event.</div>
          </div>
        </div>

        <div class="publish-row">
          <div></div>
          <button type="submit" class="admin-btn admin-btn-primary">
            <?= $action === 'edit' ? 'Save Changes' : 'Add Event' ?>
          </button>
        </div>
      </div>

    </form>
    <?php endif; ?>

  </div>
</main>

</body>
</html>