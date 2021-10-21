@extends('master')

@section('content')
<h1 class="text-center">Upload video to vimeo</h1>
<hr>
<form action="{{('upload.php')}}" method="post" class="mt-2" enctyp="multipart/form-data">
<input type="hidden" name="_token" id="csrf-token" value="{{csrf_token()}}"/>
<input type="text" name="title" placeholder="title"> 
<input type="text" name="description" placeholder="description"> 
<input type="file" name="video" placeholder=""> 
<button type="submit">upload</button>

</form>

@endsection