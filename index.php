<?php 
    $fruits = array(
        'Durian' => 20000, 
        'Mangga' => 15000, 
        'Rambutan' => 10000, 
        'Kelengkeng' => 25000, 
        'Apel' => 30000,
    );

    $file = 'penjualan.json';
    $getDataPenjualan = file_get_contents($file);
    $dataPenjualan = json_decode($getDataPenjualan, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Buah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary shadow-sm mb-3">
        <div class="container">
            <a class="navbar-brand text-white" href="#">
                <img src="./assets/images/buah.png" alt="logo-buah" class="img-fluid rounded-circle" width="40">
            </a>
        </div>
    </nav>

    <div class="container mb-3">
        <h3 class="fs-3 mb-3">Toko buah segar abadi</h3>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <form method="post">
                    <div class="mb-3">
                        <label for="pembeli" class="form-label">Nama Pembeli</label>
                        <input type="text" class="form-control" name="pembeli" id="pembeli" aria-describedby="NamaPembeli" required>
                    </div>
                    <div class="mb-3">
                        <label for="buah" class="form-label">Nama Buah</label>
                        <select class="form-select" aria-label="buah" name="buah" required>
                            <option selected disabled>--pilih buah---</option>
                        <?php 
                                foreach($fruits as $name => $price) {
                        ?>
                            <option value="<?= $name?>"><?= $name?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlahBeli" class="form-label">Jumlah Beli</label>
                        <input type="number" class="form-control" name="jumlahBeli" id="jumlahBeli" aria-describedby="jumlahBeli" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="hitung">Hitung</button>
                </form>
            </div>
            <div class="col-12 col-md-6">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Buah</th>
                            <th scope="col">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no=1;
                            foreach($fruits as $name => $price) {
                        ?>
                            <tr>
                                <th scope="row"><?= $no++ ?></th>
                                <td><?= $name ?></td>
                                <td><?= $price ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>

    <div class="container mb-3">
        <div class="alert alert-primary" role="alert">
            <h5>Aturan</h5>
            <ul>
                <li>Jika Total harga > 100000 diskon=10%</li>
                <li>Jika Total < 100000 diskon = 0</li>
                <li>Total Bayar = Total - diskon</li>
            </ul>
        </div>
    </div>

    <div class="container mb-3">
        <h3>Daftar Penjualan Buah</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Pembeli</th>
                    <th scope="col">Nama Buah</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Total</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Total Bayar</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(count($dataPenjualan) < 1) {
                        ?>
                        <tr>
                            <td colspan="9" class="alert alert-danger">Tidak ada data</td>
                            </tr>
                            
                <?php } else {
                    foreach($dataPenjualan as $index => $data) {
                ?>
                    <tr>
                        <th scope="row"><?= $index+1 ?></th>
                        <td><?= $data['pembeli'] ?></td>
                        <td><?= $data['buah'] ?></td>
                        <td><?= $data['jumlahBeli'] ?></td>
                        <td><?= $data['harga'] ?></td>
                        <td><?= $data['total'] ?></td>
                        <td><?= $data['diskon'] ?></td>
                        <td><?= $data['totalBayar'] ?></td>
                        <td><a class="text-decoration-none btn border-primary btn-sm" href="index.php?delete&id=<?= $data['id']?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')">❎</a></td>
                    </tr>
                <?php }} ?>
            </tbody>
        </table>
    </div>

    <div class="container mb-3">
        <div class="alert alert-primary" role="alert">
            <h5>Ketentuan</h5>
            <ul>
                <li>Gunakan File JSON untuk simpan data</li>
                <li>Gunakan Function untuk menghitung TOTAL</li>
                <li>Gunakan Array untuk memilih nama buah dan harga atau untuk harga boleh anda gunakan fungsi IF</li>
            </ul>
        </div>
    </div>

    <footer class="bg-primary py-3">
        <div class="container">
            <p class="text-center text-white">Made with ❤️ By Ardianto Nugroho &copy;2023</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php 

        if(isset($_POST['hitung'])) {
            function hitungTotalHarga($jumlah, $harga) {
                return $jumlah * $harga;
            };

            function hitungDiskon($total) {
                if($total > 100000) {
                    $diskon = 0.1;
                    $hargaDiskon = $total * $diskon;
                    $totalBayar = $total - $hargaDiskon;
                    return $result = array($hargaDiskon, $totalBayar);
                } else {
                    $diskon = 0;
                    return $result = array($diskon, $total);
                }
            }

            $pembeli = $_POST["pembeli"];
            $buah = $_POST["buah"];
            $jumlahBeli = $_POST["jumlahBeli"];
            $harga = $fruits[$buah];
            $total = hitungTotalHarga($jumlahBeli, $harga);
            $diskon = hitungDiskon($total)[0];
            $totalBayar = hitungDiskon($total)[1];

            $dataPenjualan [] = array(
                "id" => uniqid(),
                "pembeli" => $pembeli,
                "buah" => $buah,
                "jumlahBeli" => $jumlahBeli,
                "harga" => $harga,
                "total" => $total,
                "diskon" => $diskon,
                "totalBayar" => $totalBayar
            );

            $dataPenjualanJSON = json_encode($dataPenjualan, JSON_PRETTY_PRINT);
            file_put_contents($file, $dataPenjualanJSON);
        }
    
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            foreach($dataPenjualan as $key => $data) {
                if($data['id'] === $id) {
                    array_splice($dataPenjualan, $key, 1);
                }
            }

            $dataPenjualanJSON = json_encode($dataPenjualan, JSON_PRETTY_PRINT);
            file_put_contents($file, $dataPenjualanJSON);
        }
    ?>
</body>
</html>