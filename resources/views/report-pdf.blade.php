<!DOCTYPE html>
<html>
<head>
	<title>User list - PDF</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">
	<table class="table table-bordered">

		<thead>
			<th>Location</th>
            <th>Parent Category</th>
            <th>Category</th>
            <th>Count</th>
		</thead>
		<tbody>
			@foreach ($data as $dt)
                <tr>
                    <td>{{ $dt->location }}</td>
                    <td>{{ $dt->parent_category }}</td>
                    <td>{{ $dt->category }}</td>
                    <td>{{ $dt->total }}</td>
                </tr>
            @endforeach
		</tbody>
	</table>
</div>
</body>
</html>