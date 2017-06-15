<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>
	
<div class="container">
	<div class="block_dashboard full_container_dashboard">
		<div class="col nowrap full-width">
			<div class="pannel pannel-heading">
				<div class="title-dashboard full-width">
					<h1>Tableau de bord</h1>
				</div>
				<div class="date-dashboard full-width">
					<p>Periode: 25 octobre 2015 - 10 novembre 2015</p>
				</div>
			</div>
			<div class="pannel-body">
				<div class="title-dashboard full-width">
					<h3>Commandes</h3>
				</div>
				<div class="numbers_row row row-verti-center nowrap full-width">
					<div class="block_number">
						<div class="ico">
							<span class="ico-number waiting">
								<i class="material-icons">shopping_basket</i>
							</span>
						</div>
						<div class="descr">
							<p>15</p>
							<p>en attente</p>
						</div>
					</div>
					<div class="block_number">
						<div class="ico">
							<span class="ico-number developping">
								<i class="material-icons">code</i>
							</span>
						</div>
						<div class="descr">
							<p>5</p>
							<p>en développement</p>
						</div>
					</div>
					<div class="block_number">
						<div class="ico">
							<span class="ico-number testing">
								<i class="material-icons">bug_report</i>
							</span>
						</div>
						<div class="descr">
							<p>2</p>
							<p>en test</p>
						</div>
					</div>
					<div class="block_number">
						<div class="ico">
							<span class="ico-number done">
								<i class="material-icons">done</i>
							</span>
						</div>
						<div class="descr">
							<p>48</p>
							<p>terminé</p>
						</div>
					</div>
				</div>
			</div>
			<div class="pannel-body">
				<div class="title-dashboard full-width">
					<h3>Utilisateurs</h3>
				</div>
				<div class="numbers_row row row-verti-center nowrap full-width">
					<div class="block_number">
						<div class="ico">
							<span class="ico-number waiting">
								<i class="material-icons">do_not_disturb_alt</i>
							</span>
						</div>
						<div class="descr">
							<p>15</p>
							<p>sans offre</p>
						</div>
					</div>
					<div class="block_number">
						<div class="ico">
							<span class="ico-number developping">
								<i class="material-icons">person</i>
							</span>
						</div>
						<div class="descr">
							<p>5</p>
							<p>avec pack premium</p>
						</div>
					</div>
					<div class="block_number">
						<div class="ico">
							<span class="ico-number testing">
								<i class="material-icons">person_add</i>
							</span>
						</div>
						<div class="descr">
							<p>2</p>
							<p>avec pack full</p>
						</div>
					</div>
					<div class="block_number">
						<div class="ico">
							<span class="ico-number done">
								<i class="material-icons">local_pizza</i>
							</span>
						</div>
						<div class="descr">
							<p>48</p>
							<p>je sais pas</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="block_dashboard full_container_dashboard">
		<div class="col nowrap full-width">
			<div class="pannel pannel-heading">
				<div class="title-dashboard full-width">
					<h2>Commandes du mois</h2>
				</div>
			</div>
			<div class="stats_orders pannel pannel-body row row-verti-center row-hori-center nowrap">
				<div class="graph">
					<svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="300" class="ct-chart-line" style="width: 100%; height: 300;"><g class="ct-grids"><line y1="265" y2="265" x1="50" x2="626.25" class="ct-grid ct-vertical"></line><line y1="229.28571428571428" y2="229.28571428571428" x1="50" x2="626.25" class="ct-grid ct-vertical"></line><line y1="193.57142857142856" y2="193.57142857142856" x1="50" x2="626.25" class="ct-grid ct-vertical"></line><line y1="157.85714285714286" y2="157.85714285714286" x1="50" x2="626.25" class="ct-grid ct-vertical"></line><line y1="122.14285714285714" y2="122.14285714285714" x1="50" x2="626.25" class="ct-grid ct-vertical"></line><line y1="86.42857142857142" y2="86.42857142857142" x1="50" x2="626.25" class="ct-grid ct-vertical"></line><line y1="50.71428571428572" y2="50.71428571428572" x1="50" x2="626.25" class="ct-grid ct-vertical"></line><line y1="15" y2="15" x1="50" x2="626.25" class="ct-grid ct-vertical"></line></g><g><g class="ct-series ct-series-a"><path d="M50,265L50,172.143L146.042,129.286L242.083,165L338.125,50.714L434.167,157.857L530.208,165L626.25,86.429L626.25,265Z" class="ct-area"></path></g><g class="ct-series ct-series-b"><path d="M50,265L50,236.429L146.042,157.857L242.083,207.857L338.125,93.571L434.167,129.286L530.208,65L626.25,22.143L626.25,265Z" class="ct-area"></path></g></g><g class="ct-labels"><foreignObject style="overflow: visible;" x="50" y="270" width="96.04166666666667" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 96px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Lun</span></foreignObject><foreignObject style="overflow: visible;" x="146.04166666666669" y="270" width="96.04166666666667" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 96px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Mar</span></foreignObject><foreignObject style="overflow: visible;" x="242.08333333333334" y="270" width="96.04166666666666" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 96px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Mer</span></foreignObject><foreignObject style="overflow: visible;" x="338.125" y="270" width="96.04166666666669" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 96px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Jeu</span></foreignObject><foreignObject style="overflow: visible;" x="434.1666666666667" y="270" width="96.04166666666669" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 96px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Ven</span></foreignObject><foreignObject style="overflow: visible;" x="530.2083333333334" y="270" width="96.04166666666663" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 96px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Sam</span></foreignObject><foreignObject style="overflow: visible;" x="626.25" y="270" width="30" height="20"><span class="ct-label ct-horizontal ct-end" style="width: 30px; height: 20px" xmlns="http://www.w3.org/2000/xmlns/">Dim</span></foreignObject><foreignObject style="overflow: visible;" y="229.28571428571428" x="10" height="35.714285714285715" width="30"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">10</span></foreignObject><foreignObject style="overflow: visible;" y="193.57142857142856" x="10" height="35.714285714285715" width="30"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">15</span></foreignObject><foreignObject style="overflow: visible;" y="157.85714285714283" x="10" height="35.71428571428571" width="30"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">20</span></foreignObject><foreignObject style="overflow: visible;" y="122.14285714285714" x="10" height="35.71428571428572" width="30"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">25</span></foreignObject><foreignObject style="overflow: visible;" y="86.42857142857142" x="10" height="35.71428571428572" width="30"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">30</span></foreignObject><foreignObject style="overflow: visible;" y="50.71428571428572" x="10" height="35.714285714285694" width="30"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">35</span></foreignObject><foreignObject style="overflow: visible;" y="15" x="10" height="35.71428571428572" width="30"><span class="ct-label ct-vertical ct-start" style="height: 36px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">40</span></foreignObject><foreignObject style="overflow: visible;" y="-15" x="10" height="30" width="30"><span class="ct-label ct-vertical ct-start" style="height: 30px; width: 30px" xmlns="http://www.w3.org/2000/xmlns/">45</span></foreignObject></g></svg>
				</div>
				<div class="figure col col-hori-center nowrap">
					<div class="col nowrap full-width">
						<div class="full-width number_stats row row-verti-center">
							<span>156</span>&nbsp;
							<span><i class="material-icons">trending_up</i> 12%</span>
						</div>
						<p>Commandes totales</p>
					</div>
					<div class="col nowrap full-width">
						<div class="full-width number_stats row row-verti-center">
							<span>3</span>&nbsp;
							<span><i class="material-icons">trending_up</i> 7%</span>
						</div>
						<p>Commandes abandonnées</p>
					</div>
					<div class="col nowrap full-width">
						<div class="full-width number_stats row row-verti-center">
							<span>€1557.48</span>&nbsp;
							<span><i style="color: #B71C1C" class="material-icons">trending_down</i> 3%</span>
						</div>
						<p>Chiffres générés</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="full_container_dashboard row nowrap cut">
		
		<div class="block_dashboard half_block col nowrap">
			<div class="pannel pannel-heading">
				<div class="title-dashboard full-width">
					<h2>10 dernières inscriptions</h2>
				</div>
			</div>
			<div class="pannel pannel-body">
				<table class="sm_table_dash">
					<thead>
						<tr>
							<th>ID</th>
							<th>Email</th>
							<th>Nom</th>
							<th>Société</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>victor.ldf@outlook.fr</td>
							<td>Molet</td>
							<td>Trigou</td>
						</tr>
						<tr>
							<td>2</td>
							<td>antoine.balard@hotmail.fr</td>
							<td>hoell</td>
							<td>tyrian</td>
						</tr>
						<tr>
							<td>3</td>
							<td>yolo.balard@free.fr</td>
							<td>rees</td>
							<td>tyrian</td>
						</tr>
						<tr>
							<td>4</td>
							<td>pero.balard@orange.fr</td>
							<td>lola</td>
							<td>tyrian</td>
						</tr>
						<tr>
							<td>5</td>
							<td>holp.dd@hotmail.fr</td>
							<td>hoell</td>
							<td>tyrian</td>
						</tr>
						<tr>
							<td>6</td>
							<td>malard.balard@wanadoo.fr</td>
							<td>comissaire</td>
							<td>tyrian</td>
						</tr>
						<tr>
							<td>7</td>
							<td>antoine.balard@hotmail.fr</td>
							<td>hoell</td>
							<td>tyrian</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="block_dashboard half_block col nowrap">
			<div class="pannel pannel-heading">
				<div class="title-dashboard full-width">
					<h2>10 dernières commandes</h2>
				</div>
			</div>
			<div class="pannel pannel-body">
				<table class="sm_table_dash">
					<thead>
						<tr>
							<th>ID</th>
							<th>Email</th>
							<th>Nom</th>
							<th>Société</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>victor.ldf@outlook.fr</td>
							<td>Molet</td>
							<td>Trigou</td>
						</tr>
						<tr>
							<td>2</td>
							<td>antoine.balard@hotmail.fr</td>
							<td>hoell</td>
							<td>tyrian</td>
						</tr>
						<tr>
							<td>3</td>
							<td>yolo.balard@free.fr</td>
							<td>rees</td>
							<td>tyrian</td>
						</tr>
						<tr>
							<td>4</td>
							<td>pero.balard@orange.fr</td>
							<td>lola</td>
							<td>tyrian</td>
						</tr>
						<tr>
							<td>5</td>
							<td>holp.dd@hotmail.fr</td>
							<td>hoell</td>
							<td>tyrian</td>
						</tr>
						<tr>
							<td>6</td>
							<td>malard.balard@wanadoo.fr</td>
							<td>comissaire</td>
							<td>tyrian</td>
						</tr>
						<tr>
							<td>7</td>
							<td>antoine.balard@hotmail.fr</td>
							<td>hoell</td>
							<td>tyrian</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>