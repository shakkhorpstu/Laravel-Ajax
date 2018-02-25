<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>

	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
</head>

<body>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-lg-offset-3 col-lg-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Ajax ToDo List <a href="#" id="addNew" data-toggle="modal" data-target="#myModal" class="pull-right"><i class="fa fa-plus" ariahidden="true"></i></a></h3>
					</div>
					<div class="panel-body" id="items">
						<ul class="list-group">
							@foreach($items as $item)
								<li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">{{ $item->item }}
								<input type="hidden" id="itemId" value="{{ $item->id }}">
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>

			<div class="col-lg-2">
				<input type="text" placeholder="Search Here..." class="form-control" name="searchItem" id="searchItem">
			</div>

			<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-info">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="modalTitle">Add Something</h4>
						</div>
						<div class="modal-body">
							<input type="hidden" id="id">
							<input type="text" class="form-control" placeholder="Write Something" name="title" id="title">
						</div>
						<div class="modal-footer">
							{{-- <button type="button" class="btn btn-default" data-dismiss="modal" style="display: none;">Close</button> --}}
							<button type="button" class="btn btn-danger" id="delete" data-dismiss="modal" style="display: none;">Delete</button>
							<button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal" style="display: none;">Save changes</button>
							<button type="button" class="btn btn-primary" id="addItem" data-dismiss="modal">Add Item</button>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	{{ csrf_field() }}

	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<script>
		$(document).ready(function() {
			$(document).on('click', '.ourItem', function(event) {
				var title = $(this).text();
				var text = $.trim(title);
				var id = $(this).find('#itemId').val();
				$('#title').val(text);
				$('#modalTitle').text('Edit Item');
				$('#delete').show('400');
				$('#saveChanges').show('400');
				$('#addItem').hide('400');
				$('#id').val(id);
				// console.log(id);
			});

			$(document).on('click', '#addNew', function(event) {
				$('#modalTitle').text('Add New Item');
				$('#title').val("");
				$('#delete').hide('400');
				$('#saveChanges').hide('400');
				$('#addItem').show('400');
					// console.log(text);
			});

			$('#addItem').click(function(event) {
				var text = $('#title').val();
				if(text){
					$.post('list', {'text': text,'_token':$('input[name=_token]').val()}, function(data) {
					console.log(data);
					$('#items').load(location.href + ' #items');
				});
				}
				else{
					alert("Please Type Anything");
				}
			});

			$('#delete').click(function(event) {
				var id = $('#id').val();
				console.log(id);
				$.post('delete', {'id': id,'_token':$('input[name=_token]').val()}, function(data) {
					console.log(data);
					$('#items').load(location.href + ' #items');
				});
			});

			$('#saveChanges').click(function(event) {
				var id = $('#id').val();
				var text = $.trim($('#title').val());
				console.log(id);
				$.post('update', {'text': text,'id': id,'_token':$('input[name=_token]').val()}, function(data) {
					console.log(data);
					$('#items').load(location.href + ' #items');
				});
			});

			$( function() {
				$( "#searchItem" ).autocomplete({
					source: 'http://localhost:8000/search'
				});
			});
		});
	</script>
</body>
</html>