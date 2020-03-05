<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <title>Белсотбит test</title>
</head>
<body>
 <div class="container">
      <h1>Белсотбит test</h1>
        <div id="app">
            <div class="input-name">Имя файла Excel без расширения</div>
            <input  class="input-value" type="text" v-model="excel_name">
            <div class="input-name">{{column[0].title}}</div>
            <input  class="input-value" type="number" v-model="column[0].number">
            <div class="input-name">{{column[1].title}}</div>
            <input  class="input-value" type="number" v-model="column[1].number">
            <div class="input-name">{{column[2].title}}</div>
            <input  class="input-value" type="number" v-model="column[2].number">
            <div class="input-name">{{column[3].title}}</div>
            <input  class="input-value" type="number" v-model="column[3].number">
            <div class="input-name">Начиная с:</div>
            <input  class="input-value" type="number" v-model="start">
            <div class="input-name">Количество строк</div>
            <input  class="input-value" type="number" v-model="count">
            <div class="parse" @click="ParseContent()" v-if="!parse">Парсить</div>
            <div class="parse parsing" v-else="parse "><span>Парсим...</span></div>
        </div>
 </div>
 <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
<script>
    var app = new Vue(
    {
        el:"#app",
        data:()=>({
            column:[
                {title:'Артикул',number:0},
                {title:'Наименование товара',number:1},
                {title:'Цена',number:2},
                {title:'Остатки',number:3},
            ],
            parse:false,
            start:1,
            count:1,
            excel_name:null
        }),
        methods:
            {
                ParseContent()
                {
                    if(app.excel_name!=null)
                    {
                        app.parse = true;
                        let product_id = app.column[0].number;
                        let title = app.column[1].number;
                        let count = app.column[2].number;
                        let price = app.column[3].number;
                        let count_row = app.count;
                        let start = app.start;
                        $.ajax({
                            url: '/parse.php',
                            method: 'POST',
                            data: {
                                excel_name:app.excel_name,
                                product_id:product_id,
                                title:title,
                                count:count,
                                price:price,
                                start:start,
                                count_row:count_row
                            },
                            success: function(response){
                                app.parse = false;
                                console.log('ok');
                            },
                            error: function()
                                {
                                    app.parse = false;
                                    console.log('error');
                                }
                        });
                    }
                    else
                    {
                        console.log('Нет Excel с таким названием');
                    }
                }
            }
    })
</script>
</body>
</html>