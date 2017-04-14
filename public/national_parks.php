<?php 

	require __DIR__ . '/../Park.php';
	require __DIR__ . '/../Input.php';

	$title = "National Parks";

function handleOutOfRangeRequest($page, $lastPage) {
	if($page < 1 || !is_numeric($page)) {
		header("location: national_parks.php?page=1");
		die;
	} else if($page > $lastPage) {
		header("location: national_parks.php?page=$lastPage");
		die;
	}
}

function insertParks($connection) {
	if(!empty($_POST) && validateInput()) {

		$park = new Park();
		$park->name = Input::get('name');
		$park->location = Input::get('location');
		$park->dateEstablished = Input::get('date_established');
		$park->areaInAcres = Input::get('area_in_acres');
		$park->description = Input::get('description');
		$park->insert();
		
		header('location: national_parks.php');
	}
}

function validateInput() {
	if(empty($_POST['name']) || empty($_POST['location']) || empty($_POST['date_established']) || empty($_POST['area_in_acres']) || empty($_POST['description'])) {
		return false;
	} else {
		return true;
	}
}

function pageController($connection) {

	$data = [];
	$limit = 4;
	$page = Input::get('page', 1);
	insertParks($connection);

	$count = Park::count();
	$lastPage = ceil($count / $limit);

	handleOutOfRangeRequest($page, $lastPage);

	$data['parks'] = Park::paginate($page);
	$data['page'] = $page;
	$data['lastPage'] = $lastPage;

	return $data;
}

extract(pageController(Park::dbConnect()));

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link
        rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
        crossorigin="anonymous"
    >
    <link rel="stylesheet" href="national_parks.css">
    <title><?= $title ?></title>
    <style type="text/css">
    		
		h1 {
			text-align: center;
		}

    </style>
    <!--[if lt IE 9]>
    <script src="http://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js">
    </script>
    <script src="http://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js">
    </script>
    <![endif]-->
</head>
<body>
	<main class="container">
	<h1 class="col-xs-12">National Parks</h1>
	
	<table class="table table-bordered table-striped">

		<thead>
			<tr>
				<th>Name</th>
				<th>Location</th>
				<th>Date Established</th>
				<th>Area in Acres</th>
				<th>Description</th>
			</tr>
		</thead>

		<?php foreach($parks as $park): ?>
			<tbody>
				<tr>
					<td><?= $park['name'] ?></td>
					<td><?= $park['location'] ?></td>
					<td><?= $park['date_established'] ?></td>
					<td><?= $park['area_in_acres'] ?></td>
					<td><?= $park['description'] ?></td>
				</tr>
			</tbody>
		<?php endforeach; ?>

	</table>

	<?php if($page > 1): ?>
		<a href="?page=<?= $page - 1 ?>"><span class="glyphicon glyphicon-chevron-left">Previous</span></a>
	<?php endif; ?>

	<?php if($page < $lastPage): ?>	
		<a class="pull-right" href="?page=<?= $page + 1 ?>"><span class="glyphicon glyphicon-chevron-right">Next</span></a>
	<?php endif; ?>

	<br>

	<form class="form-horizontal" method="POST">
	  <fieldset>
	    <legend class="text-center">Add New National Park</legend>
	    <div class="form-group">
	      <label for="name" class="col-lg-2 control-label">Name</label>
	      <div class="col-lg-10">
	        <input name='name' type="text" class="form-control" id="name" placeholder="Name">
	      </div>
	    </div>
	    <div class="form-group">
	      <label for="location" class="col-lg-2 control-label">Location</label>
	      <div class="col-lg-10">
	        <input name='location' type="text" class="form-control" id="location" placeholder="Location">
	      </div>
	    </div>
	    <div class="form-group">
	      <label for="date_established" class="col-lg-2 control-label">Date Established</label>
	      <div class="col-lg-10">
	        <input name='date_established' type="text" class="form-control" id="date_established" placeholder="YYYY-MM-DD">
	      </div>
	    </div>
	    <div class="form-group">
	      <label for="area_in_acres" class="col-lg-2 control-label">Area in Acres</label>
	      <div class="col-lg-10">
	        <input name='area_in_acres' type="text" class="form-control" id="area_in_acres" placeholder="Area in Acres">
	      </div>
	    </div>
	    <div class="form-group">
	      <label for="description" class="col-lg-2 control-label">Description</label>
	      <div class="col-lg-10">
	        <textarea name='description' class="form-control" rows="3" id="description"></textarea>
	      </div>
	    </div>
	    <div class="form-group">
	      <div class="col-lg-10 col-lg-offset-2">
	        <button type="reset" class="btn btn-default">Cancel</button>
	        <button type="submit" class="btn btn-primary">Submit</button>
	      </div>
	    </div>
	  </fieldset>
	</form>		

	</main>
</body>
</html>