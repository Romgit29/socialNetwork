@extends('layouts.app')

@section('content')    
<div class="container">
	<div class="bg-light p-4 rounded">
		<h2>Roles</h2>
		<div class="lead">
			<div>Manage your roles here.</div>		
			<a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm float-right">Add role</a>
		</div>
		<div style='margin-top:15px'>
			@foreach ($roles as $key => $role)
				<div class="row">
					<div class="col border border">
						<b>{{ $role->name }}</b>
					</div>
					<div class="col col-md-1 border p-0 d-flex">
						<a class="btn btn-primary btn-sm w-100" href="{{ route('roles.edit', $role->id) }}" style='width:auto;'>Edit</a>
					</div>
					<div class="col col-md-1 border p-0 d-flex">
						<div class='btn btn-danger btn-sm w-100' style='width:auto;' type="submit" form="myform">
							Delete
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>

<form method="POST" name='myform' action="{{ route('roles.destroy', $role->id) }}">
	@method('delete')
	@csrf
</form>

<div class="d-flex">
  {!! $roles->links() !!}
  </div>

@endsection