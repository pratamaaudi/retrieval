<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8 form-control">
                <form action="proses.php?cmd=cosine" method="POST">
                    <div class="row">
                        <div class="col-sm-2"><span style="float: right">Keyword :</span> </div>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" name="keyword" style="width: 100%"/>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control" id="sel1" name="uMeotde">
                                <option>Manhattan</option>
                                <option>Cosine</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn" style="width: 100%">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Tweet(ORI)</th>
                            <th>Tanggal</th>
                            <th>Nilai Similaritas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>nama user</td>
                            <td>isi twiit</td>
                            <td>tanggal twiit</td>
                            <td>99</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </body>
</html>
