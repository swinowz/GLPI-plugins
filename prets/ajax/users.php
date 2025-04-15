<?php
include('../../../inc/includes.php');

$search = $_GET['searchText'] ?? '';

$results = [];

if ($search !== '') {
    $iterator = $DB->request([
        'FROM'   => 'glpi_users',
        'FIELDS' => ['id', 'name', 'realname', 'firstname'],
        'WHERE'  => [
            'OR' => [
                'name'      => ['LIKE', "%$search%"],
                'realname'  => ['LIKE', "%$search%"],
                'firstname' => ['LIKE', "%$search%"]
            ]
        ],
        'LIMIT'  => 20
    ]);

    foreach ($iterator as $row) {
        $results[] = [
            'id'    => $row['id'],
            'label' => "{$row['realname']} {$row['firstname']} ({$row['name']})"
        ];
    }
}

header('Content-Type: application/json');
echo json_encode(['results' => $results]);
