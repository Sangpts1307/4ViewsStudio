<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
       
      <title>4Views Studio</title>
      <link rel="icon" type="image/x-icon" href="/avt.ico" >
</head>
<style>
    #header {
        height: 60px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        /* căn giữa dọc */
    }

    #header .col-md-3,
    #header .col-md-6 {
        display: flex;
        align-items: center;
        /* căn giữa dọc từng cột */
    }

    #header img {
        max-height: 100%;
        object-fit: contain;
    }

    .icon-group {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .logout-icon {
        margin-left: auto;
        padding-left: 10px;
    }

    nav.navbar {
        width: 100%;
        padding-top: 0;
        padding-bottom: 0;
    }

    .navbar-nav .nav-link {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    .icon-group a {
        margin: 10px;
        border-radius: 50%;
        box-sizing: border-box;

        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        transition: 0.3s ease;

        color: var(--color);
    }

    .icon-group a:hover {
        background-color: rgba(0, 0, 0, 0.03);
        transform: scale(2);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        border: 2px solid var(--color);
        /* viền cùng màu icon */
        cursor: pointer;
    }
    #footer {
        border-top: 3px solid #f0f2f0;
        padding-top: 20px;
        background-color: #323030;
        color: white;
    }
</style>

<body>
    <div id="header">
        @include('clients.layouts.header')
    </div>

    <div id="body">
        
        @yield('content')

    </div>
    <div id="footer">
        @include('clients.layouts.footer')
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js"
    integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+" crossorigin="anonymous">
</script>

</html>
