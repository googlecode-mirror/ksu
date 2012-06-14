<?php
		  $a=new reportProduct();
		  //$a->Header();
		  $a->setKriteria("transkip");
		  $a->setNama("Laporan SPB Bulanan");
		  $a->AliasNbPages();
		  $a->AddPage("L","A4");
		  //$data=$temp_rec->row();
		  $a->Ln(2); // spasi enter
		  $a->SetFont('Arial','B',12); // set font,size,dan properti (B=Bold)
		  $a->Cell(0,4,'Bulan  : '.$bln,0,1,'L');
		  $a->Cell(0,4,'Tahun : '.$thn,0,1,'L');
		  $a->Ln(2);
	
		  $a->SetFont('Arial','',10);
		  // set lebar tiap kolom tabel transaksi
		  $a->SetWidths(array(7,40,25,40,35,40,22,22,18,25));
		  // set align tiap kolom tabel transaksi
		  $a->SetAligns(array("C","L","C","L","L","L","R","R","C","C"));
		  $a->SetFont('Arial','B',10);
		  $a->Ln(2);
		  // set nama header tabel transaksi
		  $a->SetFillColor(225,225,225);
		  $a->Cell(7,7,'No.',1,0,'C',true);
		  $a->Cell(40,7,'NO. SPB',1,0,'C',true);
		  $a->Cell(25,7,'TGL SPB',1,0,'C',true);
		  $a->Cell(40,7,'NAMA PEMILIK',1,0,'C',true);
		  $a->Cell(35,7,'NO.KTP/SIM',1,0,'C',true);
		  $a->Cell(40,7,'JENIS BARANG',1,0,'C',true);
		  $a->Cell(22,7,'TAKSIR',1,0,'C',true);
		  $a->Cell(22,7,'NILAI TAKS',1,0,'C',true);
		  $a->Cell(18,7,'JK.WAKTU',1,0,'C',true);
		  $a->Cell(25,7,'JT TEMPO',1,0,'C',true);
		  $a->Ln(7);
	
		  $a->SetFont('Arial','',10);
		  $rec = $temp_rec->result();
		  $n=0;
		  foreach($rec as $r)
		  {
			$n++;
			$a->Row(array(($n), $r->no_spb, tglfromSql($r->tgl_spb), $r->nama_spb,$r->ktp_spb,$r->id_barang,number_format($r->taksir_spb),number_format($r->nilai_spb),$r->jw_spb,tglfromSql($r->jt_spb)));
			//$a->Ln(5);
		  }
		//print_r($a);
		  $a->Output();
?>
