<!DOCTYPE html>
    <html>
        <head>
            <title>Test project</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
            <link rel="stylesheet" type="text/css" href="../css/styles.css">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <style>
                ul.tab {
                    list-style-type: none;
                    margin: 0;
                    padding: 0;
                    overflow: hidden;
                    border: 1px solid #ccc;
                    background-color: #f1f1f1;
                }
                ul.tab li {float: left;}
                ul.tab li a {
                    display: inline-block;
                    color: black;
                    text-align: center;
                    padding: 14px 16px;
                    text-decoration: none;
                    transition: 0.3s;
                    font-size: 17px;
                }
                ul.tab li a:hover {
                    background-color: #ddd;
                }
                ul.tab li a:focus, .active {
                    background-color: #ccc;
                }
                .tabcontent {
                    display: none;
                    padding: 6px 12px;
                    border: 1px solid #ccc;
                    border-top: none;
                }
            </style>
        </head>
        <body>