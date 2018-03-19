<h3>Yeni Teklif Formu</h3>
<p>Merhaba az önce web sitesi üzerinden bir sigorta teklif formu gönderildi. İstenilen teklife bilgileri aşağıdaki gibidir:</p>
<hr/>
<p><strong>Sigorta Türü:</strong> <?php echo $data["sigorta-type"];?></p>
<p><strong>İsim:</strong> <?php echo $data["sigorta-name"]; ?></p>
<p><strong>TC / Veri No:</strong> <?php echo $data["sigorta-tc"]; ?></p>
<p><strong>Telefon Numarası:</strong> <?php echo $data["sigorta-phone"]; ?></p>
<p><strong>E-Posta Adresi:</strong> <?php echo $data["sigorta-email"]; ?></p>
<?php if(isset($data["sigorta-ruhsat"])) { ?>
<p><strong>Ruhsat Serin No veya Absis No:</strong> <?php echo $data["sigorta-ruhsat"]; ?></p>
<?php } ?>
<hr/>
<p><small><em>- Mesaj Sonu -</em></small></p>