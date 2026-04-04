<?php
// data/events.php
// Upcoming events data store. Compatible with PHP 7.2+.
// Past events are automatically hidden on the blog page.
// 'end_date' => null means single-day event.

$events = array();

$events[] = array(
    'id'          => 1,
    'title'       => 'Shenandoah Valley Craft Fair',
    'date'        => '2025-05-10',
    'end_date'    => '2025-05-11',
    'location'    => 'Harrisonburg, VA',
    'venue'       => 'Rockingham County Fairgrounds',
    'address'     => '4808 S Valley Pike, Harrisonburg, VA 22801',
    'description' => 'Come find me at Booth #42! I\'ll have clay animals, watercolor prints, keychains, and some brand new pieces that haven\'t been listed online yet.',
    'link'        => null,
);

$events[] = array(
    'id'          => 2,
    'title'       => 'Downtown Staunton Artisan Market',
    'date'        => '2025-06-07',
    'end_date'    => null,
    'location'    => 'Staunton, VA',
    'venue'       => 'Wharf District',
    'address'     => 'Staunton, VA 24401',
    'description' => 'A lovely outdoor market right in downtown Staunton. Stop by and say hi — I\'ll be there all day with a full table of handmade goodies.',
    'link'        => null,
);

$events[] = array(
    'id'          => 3,
    'title'       => 'Blue Ridge Summer Arts & Crafts Show',
    'date'        => '2025-07-19',
    'end_date'    => '2025-07-20',
    'location'    => 'Roanoke, VA',
    'venue'       => 'Elmwood Park',
    'address'     => '706 S Jefferson St, Roanoke, VA 24011',
    'description' => 'One of my favourite shows of the year — great vendors, great crowds, and a beautiful outdoor setting. I\'ll have my biggest selection of the summer here.',
    'link'        => null,
);

return $events;