<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
        <title>Test Admin for JDB</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

        <script type="text/javascript">

            function useredit()
            {
                var r=confirm("Do you want to edit this user?")
                if (r==true)
                    return true;
                else
                    return false;
            }

            function userremove()
            {
                var r=confirm("Do you want to remove this user?")
                if (r==true)
                    return true;
                else
                    return false;
            }

            function conremove()
            {
                var r=confirm("Do you want to remove this contact?")
                if (r==true)
                    return true;
                else
                    return false;
            }

            function condup()
            {
                var r=confirm("Do you want to duplicate this contact?")
                if (r==true)
                    return true;
                else
                    return false;
            }

            function conedit()
            {
                var r=confirm("Do you want to edit this contact?")
                if (r==true)
                    return true;
                else
                    return false;
            }

            function fillall(){
                var x = document.getElementById("comm").value;
                document.getElementById("coms").value = x;
                document.getElementById("coms1").value = x;
                document.getElementById("coms2").value = x;

                var y = document.getElementById("emw").value;
                document.getElementById("emp").value = y;
                document.getElementById("emd").value = y;
            }
        </script>

    </head>
    <body>
        <div id="loader"></div><div id="menu">
            <a href="{{ url('') }}">
                <div class="menuel" style="border-top-left-radius:6px;">Home</div></a>
            <a href="{{ url('database') }}">
                <div class="menuel" >Database</div></a>
            <a href="{{ url('search') }}">
                <div class="menuel" >Search</div></a>
            <a href = "{{ url('users') }}">
                <div class="menuel">Users</div></a>
            <a href="{{ url('logout') }}">
                <div class="menuel" style="border-top-right-radius: 8px; ">Logout</div></a>
        </div>
        @yield('content')
    </body>
</html>