<?php

	
    class console_class {
        
        CONST TABLE_COLUMNS_AMOUNT = 3;
        CONST TABLE_STRINGS_AMOUNT = 2;

        public static function console_render ($console_name, $main_url) {
            
            print_r('<html>'); print_r('<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">');
            //print_r('<script src="js/angular.min.js"></script>');
            print_r('<script src="js/jquery.min.js"></script>');
            print_r('</head>'); print_r('<body style="background: #FFE0F9;">');
            //print_r('<script src="js/app.js"></script>');
            
            print_r('<script>');

            print_r('

                $(document).ready(function(){
                    $("#get_data_left").click(function(){
                        var id_val = $("#id_value").val();
                        var post_url = "'.$main_url.'";
                        $.post(post_url, function(data) {
                            var textarea_left = $("#textarea_left").val();
                            if ($("#textarea_left").val() != ""){
                                $("#textarea_left").val(data);
                            }    
                            else {
                                $("#textarea_left").val(data);
                            }
        
                            if ($("#signal").val() == "Send success"){
                                //$("#signal").val("Send correct");
                            }
                            else {
                                //$("#signal").val("Send success");
                            }
                        });
                    });
                    
                    $("#get_data_right").click(function(){
                        
                            var id_value_right = $("#id_value_right").val();     
                            var post_url_xml = "'.$main_url.'";
                            var textarea_right = $("#textarea_right").val();
                            $.post(post_url_xml, {deal_id : id_value_right}, function(data) {
                                if ($("#textarea_right").val() != ""){
                                    $("#textarea_right").val(data);
                                }    
                                else {
                                    $("#textarea_right").val(data);
                                }
                            });
                    });
                    
                    // $("#get_table").click(function(){
                        
                        // var cell_value_1 = $("#cell_1_1").val();
                        // var cell_value_2 = $("#cell_1_2").val();
                        // var cell_value_3 = $("#cell_1_3").val();
                        
                        // $("#cell_2_1").val($("#cell_1_1").val());
                        // $("#cell_2_2").val($("#cell_1_2").val());
                        // $("#cell_2_3").val($("#cell_1_3").val());

                    // });
                    
                });
            

            
            ');
            
            print_r('</script>');
            print_r('<center><h1 style="margin: 15px;">'); print_r($console_name); print_r('</h1></center>');
            print_r('<center>');
                //print_r('<textarea id="textarea_left" style="width: 10%; height: 400px; margin: 25px;"></textarea>');
                print_r('<textarea id="textarea_right" style="width: 90%; height: 700px; margin: 25px; font-size: 18px;"></textarea>');
                print_r('<br>');
                // print_r('<input type="text" id="id_value" value="1110" style="width: 100px; height: 25px; margin: 25px;"></input>');
                // print_r('<button id="get_data_left" style="margin: 0 20px 0 0;">Получить данные!</button>');
                
                print_r('<input type="text" id="id_value_right" value="19805" style="width: 100px; height: 25px; margin: 25px;"></input>');
                print_r('<button id="get_data_right" style="margin: 0 0 0 20px;">Отправить запрос!</button>');
                
                print_r('<br>');

            print_r('</center>');
            
            // print_r('<center>');
            
                // print_r('<br>');
            
                // print_r('<table style="border-collapse: collapse; border-spacing: 0px;">');
                
                // for ($string_count = 1; $string_count <= self :: TABLE_STRINGS_AMOUNT; $string_count++) {
                    // print_r('<tr>');
                    // for ($column_count = 1; $column_count <= self :: TABLE_COLUMNS_AMOUNT; $column_count++) {
                        // print_r('<td>'); print_r('<input id="'.'cell_'.$string_count.'_'.$column_count.'" type="text"></input>'); print_r('</td>');
                    // }
                    // print_r('</tr>');
                // }
                
                // print_r('</table>');
                
                // print_r('<br>');
                // print_r('<button id="get_table">Таблица</button>');
            
            // print_r('</center>');
            
            print_r('</body></html>');

        }
        
    }    // end class console_class
	
?>