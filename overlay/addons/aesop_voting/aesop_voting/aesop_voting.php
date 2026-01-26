<?php
/**
 * Local Voting Add-on for Friendica
 * Marks voting posts local-only and fetches results from Python service
 */

use Friendica\App;

function local_voting_install() {
    register_hook('post_local', 'addon/aesop_voting/aesop_voting.php', 'local_voting_post_local');
    register_hook('addon_settings', 'addon/aesop_voting/aesop_voting.php', 'local_voting_addon_settings');
}

function local_voting_uninstall() {
    unregister_hook('post_local', 'addon/aesop_voting/aesop_voting.php', 'local_voting_post_local');
    unregister_hook('addon_settings', 'addon/aesop_voting/aesop_voting.php', 'local_voting_addon_settings');
}

function local_voting_post_local(App $a, array &$b) {
    $item = &$b['item'];

    if (isset($item['post_type']) && $item['post_type'] === 'voting') {
        // Make voting posts local-only
        $item['private'] = 1;
        $item['allow_cid'] = [];
        $item['allow_gid'] = [];
        $item['deny_federation'] = true;

        // Send post to Python voting service
        $url = "http://voting-service:5001/vote";
        $data = json_encode([
            'post_id' => $item['id'],
            'content' => $item['body'],
            'author' => $item['author']['nickname'] ?? 'unknown'
        ]);

        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => $data,
            ],
        ];
        $context  = stream_context_create($options);
        @file_get_contents($url, false, $context);
    }
}

function local_voting_addon_settings(App $a, array &$b) {
    if (!local_user()) {
        return;
    }

    $o = '<h3>Local Voting Settings</h3>';
    $o .= '<p>Voting service URL (default: http://voting-service:5001)</p>';
    $b['addon_settings'] .= $o;
}
