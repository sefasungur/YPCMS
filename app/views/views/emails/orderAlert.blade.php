


<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:780px;" width="780">
	<tbody>
		<tr style="height:115px;">
			<td style="width:357px;border:none;border-bottom:solid #DFDFDF 1.0pt;padding:0cm 0cm 0cm 0cm;height:115px;">
			<p><a href="http://www.artsanart.com/"><span style="text-decoration:none;text-underline:none;"><img border="0" id="_x0000_i1025" src="http://artsanart.com/public/assets/img/logo.png" /></span></a></p>
			</td>
			<td style="width:357px;border:none;border-bottom:solid #DFDFDF 1.0pt;padding:0cm 0cm 0cm 0cm;height:115px;">
			<p>&nbsp;</p>
			</td>
			<td style="width:28px;border:none;border-bottom:solid #DFDFDF 1.0pt;padding:0cm 0cm 0cm 0cm;height:115px;">
			<p>&nbsp;</p>
			</td>
			<td style="width:28px;border:none;border-bottom:solid #DFDFDF 1.0pt;padding:0cm 0cm 0cm 0cm;height:115px;">
			<p>&nbsp;</p>
			</td>
			<td style="width:24px;border:none;border-bottom:solid #DFDFDF 1.0pt;padding:0cm 0cm 0cm 0cm;height:115px;">
			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="padding:15.0pt 0cm 15.0pt 0cm;vertical-align:top;">
				<p style="margin-bottom:12.0pt;"><span style="color:#1CA6DF;"><span style="font-size:27.0pt;">Artsanart.com sipariş detaylarınız. </span></span><br />
				<br />
				<span style="color:#555555;"><span style="font-size:13.5pt;">Artsanart.com&#39;a vermiş olduğunuz <a href="<?php echo $orderTrackingUrl; ?>"><?php echo $code; ?></a> kodlu siparişiniz alındı. </span></span></p>

				<table border="0" cellpadding="0">
					<tbody>
						<tr>
							<td style="width:220px;background:#555555;padding:.75pt .75pt .75pt .75pt;">
							<p><span style="color:white;"><span style="font-size:10.5pt;">&Uuml;r&uuml;n Adı</span></span></p>
							</td>
							<td style="width:100px;background:#555555;padding:.75pt .75pt .75pt .75pt;">
							<p align="center" style="text-align:center;"><span style="color:white;"><span style="font-size:10.5pt;">Miktarı</span></span></p>
							</td>
							<td style="width:100px;background:#555555;padding:.75pt .75pt .75pt .75pt;">
							<p align="center" style="text-align:center;"><span style="color:white;"><span style="font-size:10.5pt;">Birim Fiyat</span></span></p>
							</td>
							<td style="width:100px;background:#555555;padding:.75pt .75pt .75pt .75pt;">
							<p align="center" style="text-align:center;"><span style="color:white;"><span style="font-size:10.5pt;">Toplam Tutar</span></span></p>
							</td>
						</tr>
						<?php foreach ($basket["products"] as $product){ ?>
							<tr>
								<td style="padding:.75pt .75pt .75pt .75pt;">
								<p><?php echo $product["name"]; ?></p>
								</td>
								<td style="padding:.75pt .75pt .75pt .75pt;">
								<p><?php echo $product["count"]; ?></p>
								</td>
								<td style="padding:.75pt .75pt .75pt .75pt;">
								<p><?php echo $product["price"] ?></p>
								</td>
								<td style="padding:.75pt .75pt .75pt .75pt;">
								<p><?php echo $product["total"] ?></p>
								</td>
							</tr>							
						<?php } ?>
					</tbody>
				</table>

				<p style="margin-bottom:12.0pt;"><br />
					<p><strong>Ad soyad:</strong><?php echo $ad_soyad; ?></p>
					<p><strong>E-Posta:</strong><?php echo $eposta; ?></p>
					<p><strong>Telefon:</strong><?php echo $telefon; ?></p>
					<p><strong>Fatura_adres Adresi:</strong><?php echo $fatura_adres; ?></p>
					<p><strong>Teslimat Adresi:</strong><?php echo $teslimat_adres; ?></p>
					<p><strong>Ödeme Şekli:</strong><?php echo $odeme_sekli; ?></p>
					<p><strong>Mesaj:</strong><?php echo $mesaj; ?></p>
				</p>
			</td>
		</tr>
	</tbody>
</table>
