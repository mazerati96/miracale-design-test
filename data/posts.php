<?php
// data/posts.php
// Blog post data store. Compatible with PHP 7.2+.
// To add a post: copy one entry, fill in content, give it a unique id and slug.
// Set 'published' => false to draft without deleting.

$posts = array();

$posts[] = array(
    'id'        => 1,
    'slug'      => 'welcome-to-the-blog',
    'title'     => 'Welcome to the Miracale Design Blog!',
    'excerpt'   => 'A little hello from the artist — what this blog is for, what to expect, and a peek at what\'s coming next.',
    'body'      => '<p>Hi there, and welcome! I\'m so glad you found your way here.</p>
                    <p>This little corner of the site is where I\'ll be sharing everything — new pieces I\'m working on, behind-the-scenes looks at my process, upcoming craft fairs I\'ll be at, and just general life as a handmade artist in Virginia.</p>
                    <p>I\'ve been making things by hand for as long as I can remember. Clay, watercolors, wood — there\'s something about working with your hands that never gets old. Every piece is a tiny adventure, and I want to share more of that with you here.</p>
                    <p>Thanks for being here. Stay tuned for more! 🎨</p>',
    'image'     => null,
    'category'  => 'Updates',
    'author'    => 'Miracale Design',
    'published' => true,
    'date'      => '2025-04-01',
);

$posts[] = array(
    'id'        => 2,
    'slug'      => 'how-i-make-clay-animals',
    'title'     => 'How I Make My Clay Animals',
    'excerpt'   => 'From a lump of polymer clay to a finished fox — a peek into the process behind one of my most popular pieces.',
    'body'      => '<p>People ask me all the time how long it takes to make a clay animal. Honestly? It depends — but never as fast as you\'d think!</p>
                    <p>I start with a reference photo, usually of the real animal. Then I condition the clay (basically knead it until it\'s soft and workable), and start blocking out the basic shape. The body always comes first, then the head, then the details.</p>
                    <p>The details are my favourite part. Little ears, tiny paws, the curve of a tail — those are the bits that give each piece its personality. No two animals ever come out exactly the same, even if I\'m making the same species twice.</p>
                    <p>After sculpting, everything goes into the oven at 275°F for about 15–20 minutes. Then sanding, painting, and a coat of varnish to seal it all in.</p>
                    <p>Start to finish, a small animal takes about 2–3 hours. A bigger or more detailed piece can take a full day. But I love every minute of it.</p>',
    'image'     => null,
    'category'  => 'Process',
    'author'    => 'Miracale Design',
    'published' => true,
    'date'      => '2025-03-20',
);

$posts[] = array(
    'id'        => 3,
    'slug'      => 'spring-craft-fair-prep',
    'title'     => 'Getting Ready for Spring Craft Fair Season',
    'excerpt'   => 'It\'s that time of year! Here\'s how I prepare for craft fairs, what I bring, and what to expect if you see me at one.',
    'body'      => '<p>Spring is officially here and that means craft fair season is kicking off! I\'ve been in full preparation mode — building up inventory, making new display pieces, and figuring out what sold best last year.</p>
                    <p>Craft fairs are honestly my favourite way to connect with people. There\'s something special about watching someone pick up a piece, turn it over in their hands, and just fall in love with it right in front of you.</p>
                    <p>This year I\'m bringing a bigger selection of clay animals, some new watercolor prints, and a whole batch of keychains that I\'m really excited about. Check the Events tab for dates and locations!</p>',
    'image'     => null,
    'category'  => 'Events',
    'author'    => 'Miracale Design',
    'published' => true,
    'date'      => '2025-03-10',
);

return $posts;