<form action="{{ url('video') }}" method="post" enctype="multipart/form-data">
    <p><input type="text" name="title" placeholder="Enter Video Title" /></p>
    <p><textarea name="description" cols="30" rows="10" placeholder="Video description"></textarea></p>
    <p><input type="file" name="video" /></p>
    <button type="submit" class="btn btn-default">Submit</button>
    {{ csrf_field() }}
</form>