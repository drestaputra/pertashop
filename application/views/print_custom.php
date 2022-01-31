<!doctype html>
<html class="fixed">
<head>

	<!-- Basic -->
	<meta charset="UTF-8">
	
	<meta name="author" content="Dresta TAP & OemahWeb">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.css" />
	<style type="text/css">
		@media print{@page {size: landscape}}
	</style>
	
</head>
<body>
	<style type="text/css"></style>
	
	<!-- start: page -->
	<section class="body-sign">
		<div class="center-sign text-center">
			<table class="table table-bordered table-responsive table-striped">
				<thead>
					<tr>
						<th>No.</th>
						<th>Aset</th>
						<th>OPD</th>
						<th>Kode</th>
						<th>Register</th>
						<th>Luas</th>
						<th>Tahun</th>
						<th>Alamat</th>
						<th>Jenis Hak</th>
						<th>Tgl. Sertif</th>
						<th>Nomor Sertif</th>
						<th>Penggunaan</th>
						<th>Asal Perolehan</th>
						<th>Harga Perolehan</th>
						<th>Keterangan</th>
						<th>Status Aset</th>
						<th>Status Verifikasi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($aset as $key => $value): ?>
					<tr>
						<td><?php echo $key+1 ?></td>
						<td><?php echo (isset($value['nama_aset']) AND !empty($value['nama_aset'])) ? $value['nama_aset'] : "" ?></td>
						<td><?php echo (isset($value['sea67d6ad']) AND !empty($value['sea67d6ad'])) ? $value['sea67d6ad'] : "" ?></td>
						<td><?php echo (isset($value['kode_barang']) AND !empty($value['kode_barang'])) ? $value['kode_barang'] : "" ?></td>
						<td><?php echo (isset($value['register']) AND !empty($value['register'])) ? $value['register'] : "" ?></td>
						<td><?php echo (isset($value['luas_tanah']) AND !empty($value['luas_tanah'])) ? $value['luas_tanah'] : "" ?></td>
						<td><?php echo (isset($value['tahun_perolehan']) AND !empty($value['tahun_perolehan'])) ? $value['tahun_perolehan'] : "" ?></td>
						<td><?php echo (isset($value['alamat']) AND !empty($value['alamat'])) ? $value['alamat'] : "" ?></td>
						<td><?php echo (isset($value['jenis_hak']) AND !empty($value['jenis_hak'])) ? $value['jenis_hak'] : "" ?></td>
						<td><?php echo (isset($value['tanggal_sertifikat']) AND !empty($value['tanggal_sertifikat'])) ? $value['tanggal_sertifikat'] : "" ?></td>
						<td><?php echo (isset($value['nomor_sertifikat']) AND !empty($value['nomor_sertifikat'])) ? $value['nomor_sertifikat'] : "" ?></td>
						<td><?php echo (isset($value['penggunaan']) AND !empty($value['penggunaan'])) ? $value['penggunaan'] : "" ?></td>
						<td><?php echo (isset($value['asal_perolehan']) AND !empty($value['asal_perolehan'])) ? $value['asal_perolehan'] : "" ?></td>
						<td><?php echo (isset($value['harga_perolehan']) AND !empty($value['harga_perolehan'])) ? number_format($value['harga_perolehan'],0,".",".") : "" ?></td>
						<td><?php echo (isset($value['keterangan']) AND !empty($value['keterangan'])) ? $value['keterangan'] : "" ?></td>
						<td><?php echo (isset($value['status_aset']) AND !empty($value['status_aset'])) ? $value['status_aset'] : "" ?></td>
						<td><?php echo (isset($value['status_verifikasi_aset']) AND !empty($value['status_verifikasi_aset'])) ? $value['status_verifikasi_aset'] : "" ?></td>
						
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>

			

			
		</div>
	</section>
	<!-- end: page -->

	<!-- Vendor -->
	<script href="<?php echo base_url(); ?>assets/vendor/jquery/jquery.js"></script>
	<script type="text/javascript">
		window.print();
		window.onafterprint = window.close;
	</script>


</body>
</html>