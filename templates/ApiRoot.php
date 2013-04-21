<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <style>
        body {font-family:sans-serif; font-size:10pt; color:DarkSlateGray;}
        a {color:CornFlowerBlue;}
        pre {font-size:0.8em;}
        table {border-collapse:collapse;}
        table thead tr th {line-height:2em; padding:0 1ex; font-weight:normal;}
        table tbody tr td {line-height:2em; padding:0 1ex;}
        table tbody tr:nth-child(odd) td { background-color:GostWhite; }
        table tbody tr:nth-child(even) td { background-color:Gainsboro; }
        table tbody tr:nth-child(odd) td:nth-child(odd) { color:black; opacity:0.8; }
        table tbody tr:nth-child(even) td:nth-child(odd) { color:black; opacity:0.8; }
    </style>
</head>

<body>
    <p>Méthodes : <a href="?method=post">post</a>, <a href="?method=get">get</a>, <a href="?method=put">put</a> ou <a href="?method=delete">delete</a></p>
    <p>Codes de retour : <a href="?return=200">200</a>, <a href="?return=201">201</a>, <a href="?return=204">204</a>, <a href="?return=404">404</a></p>
    <table>
        <thead><tr><th>Méthode</th><th>URL</th><th>Description</th><th>Code retour</th></tr></thead>
        <tbody>
            <?php foreach($table as $row): ?>
            <tr>
                <td><code><?= $row[0] ?></code></td>
                <td><code><?= $row[1] ?></code></td>
                <td><?= $row[2] ?></td>
                <td><code><?= implode(', ', $row[3]) ?></code></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
