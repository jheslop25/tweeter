<div class="container">
    <div class="card mx-3 p-3">
        <form class="form-inline p-3" action="/tweets/create" method="post" enctype="multipart/form-data">
            @csrf
                <input class="form-control w-75" type="text" name="content" placeholder="@ {{Auth::user()->name}} ~ what's on your mind?">
                <img class="img-fluid" style="width: 60px;" src="{{ url('/logo.png')}}" alt="The Great Ironic Eagle">
                <label for="myPhoto" class="btn btn-secondary my-2 mr-2">Select photo
                    <input class="d-none" type="file" id='myPhoto' name="myPhoto">
                </label>
                <button class="btn btn-primary m-md-2" type="submit">Publish</button>
        </form>
    </div>
    @error('content')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
