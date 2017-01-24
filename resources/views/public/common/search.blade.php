@if(count($posts) > 0)
    <form method="post" class="m-t-s" action="{{route('search')}}">
        {{csrf_field()}}
        <p class="control">
            <input class="input" type="text" placeholder="Search in posts" name="term">
        </p>
        <button type="submit" class="button is-primary is-outlined">Search</button>
    </form>
@endif
