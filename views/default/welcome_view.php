
		<!-- BEGIN CONTENT -->
		<div id="content">
			<h1>Halo User!</h1>
			<p>Terima kasih telah menggunakan framework MIRAS. Ini adalah 
			controller default yang berlokasi di: </p>
			
			<code>./controllers/main_ctl.php</code>
			
			<p>Pada distribusi disertakan 2 plugin yaitu <strong>Secure URL</strong>
			dan <strong>Tugu Pahlawan</strong>, keduanya ada di lokasi:</p>
			
			<code>./controllers/plugins/secure_url<br/>./controllers/plugins/tugu_pahlawan</code>
			<p>Plugin Tugu Pahlawan diciptakan untuk melakukan demonstrasi dasar bagaimana
			menggunakan sistem plugin Miras. Untuk keterangan lengkap silahkan
			merujuk pada dokumentasi.</p>
			
			<p>Secara default, fitur debugging akan diaktfikan. Jika anda tidak ingin
			mengaktifkan debugging maka set debug_mode pada file <strong>mr/site_config.php</strong>
			menjadi FALSE.</p>
			
			<p>Dari</p>
			<code>$_MR['debug_mode'] = TRUE;</code>
			
			<p>Menjadi</p>
			<code>$_MR['debug_mode'] = <strong>FALSE</strong>;</code>
			
			<h1 style="color:#c60000;">Peringatan!</h1>
			<p>Status <?php echo (FRAMEWORK_SHORT_VERSION);?> masih merupakan tahap awal pengembangan
			dan belum mencapai status versi <strong>stable</strong>. Oleh karena itu kami sangat
			tidak menganjurkan untuk digunakan dalam lingkungan live production. Versi stable
			kemungkinan baru akan dicapai pada rilis v1.2. Jadi stay updates dengan 
			mengunjungi <a href="http://miras.raweet.og/">miras.raweet.org</a> atau 
			lewat twitter <a href="http://twitter.com/MirasFramework">@MirasFramework</a>.</p>
		</div>
		<!-- END CONTENT -->
