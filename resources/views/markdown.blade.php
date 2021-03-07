<div class="{{$viewClass['form-group']}}">

	<label class="{{$viewClass['label']}} control-label">{!! $label !!}</label>

	<div class="{{$viewClass['field']}}">

		@include('admin::form.error')

		<div class="{{$class}}" >
			<textarea class="d-markdown" {!! $attributes !!} name="{{$name}}" placeholder="{{ $placeholder }}">{!! $value !!}</textarea>
		</div>

		@include('admin::form.help-block')

	</div>
</div>

<script require="@ghost.dcat-markdown">
	var options = {!! $options !!};

	$("#"+options.id).extensionDropzone(options);
</script>

