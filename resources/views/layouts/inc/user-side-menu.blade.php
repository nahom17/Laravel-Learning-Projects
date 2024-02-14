    <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0">
        <div>
            <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <span class="fs-1 d-none d-sm-inline">Menu</span>
            </a>
            <ul class="nav flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start " id="myDIV">
                <li class="nav-item treeview-menu" id="myDIV">

                {{-- @php
                $posts = App\Models\Article::all();
            @endphp
            @php
                $users = App\Models\User::all();
            @endphp
            @php
                $projects = App\Models\Project::all();
            @endphp --}}
            <a href="{{ route('profile.profile')}}" class="dropdown-item side-menu">Mijn profile</a>
            <a href="{{ route('articles.myArticles')}}" class="dropdown-item side-menu">Mijn artikelen</a>
            <a href="{{ route('projects.myProjects')}}" class="dropdown-item side-menu"> Mijn projecten</a>
            <a href="{{ route('tasks.openTask')}}" class="dropdown-item side-menu"> Mijn taken</a>

            <a class="dropdown-item side-menu"  href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Uitloggen') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
            </a>
                </li>

            </ul>
        </div>
    </div>
    {{-- <style>
    #myDIV {
  border: none;
  outline: none;
  /* padding: 10px 16px; */
  background-color: #fffdfd;
  cursor: pointer;
  font-size: 18px;
}
  .side-menu:hover {
  background-color: #107bb0;
  color:rgb(251, 248, 248);
}

.menu-open{
    background-color:green;

}

</style> --}}
{{-- <script>
    $(document).ready(function () {
var url = window.location;
const allLinks = document.querySelectorAll('.dropdown-item a');
    const currentLink = [...allLinks].filter(e => {
    return e.href == url;
    });

    //fix for "cannot read property 'style' of null" on windows.location urls not in the nav, indefined on edit/create pages with id number
    if (typeof currentLink[0] !== 'undefined') {
        if (currentLink[0].closest(".side-menu") !== null) {
            currentLink[0].classList.add("active");
            currentLink[0].closest(".side-menu").style.display = 'block';
            currentLink[0].closest(".has-side-menu").classList.add("active");
            currentLink[0].closest(".has-side-menu").classList.add("menu-open");
        }
    }

});
</script> --}}
