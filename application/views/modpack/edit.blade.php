@layout('layouts/modpack')
@section('content')
<h1>Modpack Management</h1>
<hr>
<h2>Edit Modpack: {{ $modpack->name }}</h2>
<p>Editing a modpack requires that the resources exist just like when you create them. If the slug is changed, make sure to move the resources to the new area.</p>
@if ($errors->all())
	<div class="alert alert-error">
	@foreach ($errors->all() as $error)
		{{ $error }}<br />
	@endforeach
	</div>
@endif
<form class="form-horizontal" method="POST" action="{{ URL::current() }}" accept-charset="UTF-8" enctype="multipart/form-data">
{{ Form::control_group(Form::label('name', 'Modpack Name'), Form::xxlarge_text('name', $modpack->name)) }}
{{ Form::control_group(Form::label('slug', 'Modpack Slug'), Form::xxlarge_text('slug', $modpack->slug)) }}
<div class="control-group">
	<label class="control-label" for="hidden">Hide Modpack</label>
	<div class="controls">
		<input type="checkbox" name="hidden" id="hidden"{{ $checked = ($modpack->hidden ? ' checked' : '') }}>
		<span class="help-block">Hidden modpacks will not show up in the API response for the modpack list regardless of whether or not a client has access to the modpack.</span>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="private">Private Modpack</label>
	<div class="controls">
		<input type="checkbox" name="private" id="private"{{ ($modpack->private ? ' checked' : '') }}>
		<span class="help-block">Private modpacks will only be available to clients that are linked to this modpack. You can link clients below. You can also individually mark builds as private.</span>
	</div>
</div>
<h3>Client Access</h3>
<p>Check the clients below you want to have access to this modpack if anything is set to private.</p>
@foreach (Client::all() as $client)
<div style="display: inline-block; padding-right: 10px;"><input type="checkbox" name="clients[]" value="{{ $client->id }}"{{ (in_array($client->id, $clients) ? ' checked' : '') }}> {{ $client->name }}</div>
@endforeach
{{ Form::actions(array(Button::primary_submit('Edit Modpack'),Button::danger_link(URL::to('modpack/delete/'.$modpack->id),'Delete Modpack'))) }}
{{ Form::close() }}
<script type="text/javascript">
$("#slug").slugify('#name');
</script>
@endsection