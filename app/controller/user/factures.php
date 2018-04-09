<?php
    use Spipu\Html2Pdf\Html2Pdf;
    protec();
    ob_start();
?>
<?php if($_GET['id_facture']){ ?>
<style type="text/css">

table
{
    width:100%;
    border:none;
    border-collapse: collapse;
}
.datatables th
{
    text-align: center;
    border: solid 1px #eee;
    background: #f8f8f8;
    text-align:left;
    padding-left:10px;
}
.datatables td
{
    text-align: center;
    border: solid 1px #eee;
    text-align:left;
    padding:10px;
}
.bcolor{
    border:2px solid #0676b2;
}
.btop{
    border-top:1px solid #0676b2;
    padding-top:20px;
    color:#0676b2;
}
</style>
<table cellspacing="0" style="width: 100%;">
	<tr>
		<td height="20"></td>
	</tr>
	<tr>
		<td align="center">
			<table align="center" style="min-width:1000px">
				<tr>
					<td width="350" align="left" valign="middle"><img width="200" src="webroot/img/logo_mc.png" title="" alt=""></td>
                    
                    <td width="350" align="right" valign="middle" style="font-size:12px;color:#0676b2;font-family:Arial;">
						<b style="font-size:16px;">Facture</b>
						<br />
						Réf. : <?php echo $_GET['id_facture'] ?>
						<br />
						Date facturation : <?php echo $_GET['date_facture'] ?>
					</td>
				</tr>
			</table>
		</td>
    </tr>
    <tr>
		<td height="40"></td>
    </tr>
    <tr>
		<td align="center">
			<table align="center" style="min-width:1000px">
				<tr>
					<td width="350" align="left" valign="middle">
                        <table align="left" width="200">
                            <tr>
                                <td align="left" width="200" bgcolor="#0676b2" valign="middle" style="font-size:12px;color:#ffffff;font-family:Arial;">
                                    <table align="left" width="200">
                                        <tr>
                                            <td height="20" colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td width="20"></td>
                                            <td height="10">
                                                <b>Mailcooking / CRMCurve</b>
                                                <br />
                                                10, rue de Penthièvre
                                                <br />
                                                75008 Paris
                                            </td>
                                            <td width="20"></td>
                                        </tr>
                                        <tr>
                                            <td height="20" colspan="3"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    
                    <td width="350" align="right" valign="middle">
                        <table align="right" width="200">
                            <tr>
                                <td class="bcolor" align="right" width="200" valign="middle" style="font-size:12px;color:#0676b2;font-family:Arial;">
                                    <table align="left" width="200">
                                        <tr>
                                            <td height="20" colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td width="20"></td>
                                            <td height="10" height="35" align="left"  valign="middle">
                                                <b><?php echo $_GET['societe']; ?></b>
                                                <br />
                                                <?php echo $_GET['adress']; ?>
                                            </td>
                                            <td width="20"></td>
                                        </tr>
                                        <tr>
                                            <td height="20" colspan="3"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
				</tr>
			</table>
		</td>
    </tr>
    <tr>
		<td height="40"></td>
    </tr>
    <tr>
        <td align="center">
            <table class="datatables" align="center" style="min-width:1000px">
                <tr>
                    <th width="310" height="20">Désignation</th>
                    <th width="100" height="20">TVA</th>
                    <th width="100" height="20">P.U HT</th>
                    <th width="100" height="20">Total</th>
                </tr>
                <tr>
                    <td><?php echo $_GET['designation'] ?></td>
                    <td>20%</td>
                    <td><?php echo round($_GET['price'] / 1.2, 2) ?></td>
                    <td><?php echo $_GET['price'] ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
		<td height="20"></td>
    </tr>
    <tr>
        <td align="right">
            <table class="datatables" align="center" style="min-width:1000px">
                <tr>
                    <td width="200" align="center">
                        <b>Total HT :</b> <?php echo round($_GET['price'] / 1.2, 2).'€' ?>
                        <br />
                        <b>Total TVA 20% :</b> <?php echo ($_GET['price'] - round($_GET['price'] / 1.2, 2)).'€' ?>
                        <br />
                        <b>Total TTC :</b> <?php echo $_GET['price'] .'€' ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
		<td height="80"></td>
    </tr>
    <tr>
        <td align="center">
            <table align="center" style="min-width:1000px">
                <tr>
                    <td align="center" class="btop">
                        Société à responsabilité limitée (SARL) - Capital de 7 503 € - SIRET: 81137763900018
                        <br />
                        NAF-APE: 6202A - RCS/RM: 811377639 R.C.S. Paris - Num. TVA: 88811377639
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?php
    $content = ob_get_clean();
    $html2pdf = new Html2Pdf();
    $html2pdf->writeHTML($content);
    $outupt = $_GET['id_facture'] .'.pdf';
    $html2pdf->output($outupt);
?>

<?php }
else{
    die('facture introuvable');
}
?>