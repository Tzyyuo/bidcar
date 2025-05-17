<?php
include __DIR__ . '/../config/koneksi.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Penawar</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        .table-wrap {
            margin-top: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f1f1f1;
        }

        .status-menang {
            color: green;
            font-weight: bold;
        }

        .status-kalah {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>

</body>

</html>
<div class="table-wrap">
    <h3>List Penawar</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Harga Tawar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $id_lelang = $_GET['id_lelang'] ?? null;

            if ($id_lelang !== null) {
                $query = "SELECT m.nama_lengkap, h.penawaran_harga, h.status 
                FROM history_lelang h
                JOIN tb_masyarakat m ON h.id_user = m.id_user
                WHERE h.id_lelang = ?";

                $stmt = $koneksi->prepare($query);
                $stmt->bind_param("i", $id_lelang);
                $stmt->execute();
                $result = $stmt->get_result();

                $nomor = 1;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $nama_lengkap = $row['nama_lengkap'];
                        $penawaran_harga = $row['penawaran_harga'];
                        $status = ['menang' => 'Menang', 'kalah' => 'Kalah'][$row['status']] ?? 'Belum ada';
            ?>
                        <tr>
                            <td><?= $nomor++ ?></td>
                            <td><?= $nama_lengkap ?></td>
                            <td><?= $penawaran_harga ?></td>
                            <td><?= $status ?></td>
                        </tr>
            <?php
                    }
                } else {
                
                    echo '<tr><td colspan="4">Belum ada penawaran untuk lelang ini.</td></tr>';
                }
            } else {
                echo '<tr><td colspan="4">ID lelang tidak ditemukan.</td></tr>';
            }
            ?>

        </tbody>
    </table>