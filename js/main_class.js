/*********************************************************************************
* Описание: Модуль передачи заявок в pmsv.
* Организация: Lebedev IP.
* Автор: Лебедев Д.В.
* Система контроля версий
* Версия 1.0.0.3 от 14.11.2021
* Время начала: 18:04
* Комментарий: Реализованы методы автоматического формирования пакетов для batch 
* и для формирования списка id контактов для по ids компаний.
* Время окончания: 18:04
* Версия 1.0.0.4 от 14.11.2021
* Время начала: 18:04
* Комментарий: Создан метод формирования списка контактов.
* Время окончания: 22:47
* Версия 1.0.0.5 от 15.11.2021
* Время начала: 04:30
* Комментарий: Сформировано полностью зависимое динамическое формирование
* таблицы контактов в зависимости от таблицы компаний.
* Время окончания: 05:22
* Версия 1.0.0.6 от 15.11.2021
* Время начала: --:--
* Комментарий: Реализована передача и возврат наблюдателей. Провередно тестирование,
* отключен функционал увольнения.
* Время окончания: 16:01
* Версия 1.0.0.7 от 16.11.2021
* Время начала: --:--
* Комментарий: Добавлен и протестирован режим увольнения.
* Время окончания: 16:30
*********************************************************************************/


                function change_resp_user(table_ids_array, table_check_names_array, table_methodes_array, new_users_id_array, main_user_id, last_resp_user_name, essences_array, app_mode, base_employee_name) {

                    //console.log(base_employee_name);

                    // $select_array[0] = 'UF_AUTO_517665449295'; // Предыдущий ответственный (ФИО)
                    // $select_array[1] = 'UF_AUTO_875680162853'; // Предыдущий ответственный (ID)
                    // $select_array[2] = 'UF_AUTO_969809737336'; // Уволенный сотрудник (ФИО)
                    // $select_array[3] = 'UF_AUTO_958984612536'; // Уволенный сотрудник (ID)
                    // $select_array[4] = 'UF_AUTO_406164185840'; // Предыдущий аудитор (ФИО)
                    // $select_array[5] = 'UF_AUTO_625870498471'; // Предыдущий аудитор (ID)
                    // $select_array[6] = 'UF_AUTO_807773390305'; // Предыдущий постановщик (ФИО)
                    // $select_array[7] = 'UF_AUTO_897821339906'; // Предыдущий постановщик (ID)
                    // $select_array[8] = 'UF_AUTO_149878642279'; // Предыдущий замененный аудитор (ID)

                    //console.log(table_ids_array);
                    
                    let auditor_replace_user_id; // = 'UF_AUTO_149878642279';
                    
                    let data_array = []; let common_count = 0; let auditors_array = []; let replaced_auditor;
                    for (var main_count = 0; main_count < table_ids_array.length; main_count++) {
    
                        let table_obj = document.getElementById(table_ids_array[main_count]);
                        let checkboxes = document.getElementsByName(table_check_names_array[main_count]);
                        let new_user_id = new_users_id_array[main_count];                        
                        
                        //console.log('table_ids_array[main_count]: '); console.log(table_ids_array[main_count]);

                        //console.log(main_user_id + ' - ' + new_user_id);
                        //console.log(checkboxes);
                        //console.log(table_obj);
 
                        let essence = essences_array[main_count];
                        //console.log('new_user_id ' + essence + ': ' + new_user_id);
                        let row_count = 0; 
                        for (let row of table_obj.rows) {
                            
                            if (row_count > 0) {
                                
                                let checked_flag = true;
                                if (essence != 'contact'){
                                    checked_flag = checkboxes[row_count - 1].checked;
                                }
                                if (checked_flag) {
                                    
                                    let essence_id = table_obj.rows[row_count].cells[2].textContent;
                                    let lead_id = table_obj.rows[row_count].cells[2].textContent;
                                    
                                    if (app_mode == 1) {
                                        if (essence == 'companie') {
                                            if (new_user_id != 0) {
                                                data_array[common_count] = {method: table_methodes_array[main_count], params: {'ID' : essence_id, fields: {'ASSIGNED_BY_ID' : new_user_id, 'UF_CRM_1544552542' : main_user_id}}};
                                            }
                                        }
                                        else if (essence == 'contact') {
                                            if (new_user_id != 0) {
                                                data_array[common_count] = {method: table_methodes_array[main_count], params: {'ID' : essence_id, fields: {'ASSIGNED_BY_ID' : new_user_id, 'UF_CRM_1635104431' : main_user_id}}};
                                            }
                                        }
                                        else if (essence == 'deal') {
                                            if (new_user_id != 0) {
                                                data_array[common_count] = {method: table_methodes_array[main_count], params: {'ID' : essence_id, fields: {'ASSIGNED_BY_ID' : new_user_id, 'UF_CRM_1635104330' : main_user_id}}};
                                            }
                                        }
                                        else if (essence == 'task_resp') {
                                            if (new_user_id != 0) {
                                                data_array[common_count] = {method: table_methodes_array[main_count], params: {'taskId' : essence_id, fields: {'RESPONSIBLE_ID' : new_user_id, 'UF_AUTO_875680162853' : main_user_id}}};
                                            }
                                        }
                                        else if (essence == 'task_setter') {
                                            if (new_user_id != 0) {
                                                data_array[common_count] = {method: table_methodes_array[main_count], params: {'taskId' : essence_id, fields: {'CREATED_BY' : new_user_id, 'UF_AUTO_897821339906' : main_user_id}}};
                                            }
                                        }
                                        else if (essence == 'task_auditor') {
                                            if (new_user_id != 0) {
                                                auditors_array = table_obj.rows[row_count].cells[4].textContent.split(',');
                                                const index = auditors_array.indexOf(String(main_user_id));
                                                if (index != -1) {
                                                    auditors_array.splice(index, 1);
                                                }
                                                auditors_array[auditors_array.length] = new_user_id;
                                                data_array[common_count] = {method: table_methodes_array[main_count], params: {'taskId' : essence_id, fields: {'AUDITORS' : auditors_array, 'UF_AUTO_625870498471' : main_user_id, 
                                                'UF_AUTO_149878642279' : new_user_id}}};
                                            }
                                        }
                                    }
                                    
                                    else if (app_mode == 2) {
                                        
                                        if (essence == 'companie') {
                                            data_array[common_count] = {method: table_methodes_array[main_count], params: {'ID' : essence_id, fields: {'ASSIGNED_BY_ID' : main_user_id, 'UF_CRM_1544552542' : ''}}};
                                        }
                                        else if (essence == 'contact') {
                                            data_array[common_count] = {method: table_methodes_array[main_count], params: {'ID' : essence_id, fields: {'ASSIGNED_BY_ID' : main_user_id, 'UF_CRM_1635104431' : ''}}};
                                        }
                                        else if (essence == 'deal') {
                                            data_array[common_count] = {method: table_methodes_array[main_count], params: {'ID' : essence_id, fields: {'ASSIGNED_BY_ID' : main_user_id, 'UF_CRM_1635104330' : ''}}};
                                        }
                                        else if (essence == 'task_resp') {
                                            data_array[common_count] = {method: table_methodes_array[main_count], params: {'taskId' : essence_id, fields: {'RESPONSIBLE_ID' : main_user_id, 'UF_AUTO_875680162853' : ''}}};
                                        }
                                        else if (essence == 'task_setter') {
                                            data_array[common_count] = {method: table_methodes_array[main_count], params: {'taskId' : essence_id, fields: {'CREATED_BY' : main_user_id, 'UF_AUTO_897821339906' : ''}}};
                                        }
                                        else if (essence == 'task_auditor') {
                                            auditors_array = table_obj.rows[row_count].cells[4].textContent.split(',');
                                            replaced_auditor = table_obj.rows[row_count].cells[5].textContent;
                                            //ufAuto149878642279
                                            if (replaced_auditor != '' || replaced_auditor != 'null') {
                                                const index = auditors_array.indexOf(String(replaced_auditor));
                                                if (index != -1) {
                                                    auditors_array.splice(index, 1);
                                                }
                                            }
                                            auditors_array[auditors_array.length] = main_user_id;
                                            //console.log('task_auditor');
                                            data_array[common_count] = {method: table_methodes_array[main_count], params: {'taskId' : essence_id, fields: {'AUDITORS' : auditors_array, 'UF_AUTO_625870498471' : '', 'UF_AUTO_149878642279' : ''}}};
                                        }
                                        
                                    }
                                    
                                    else if (app_mode == 3) { // dissipation
                                    
                                        // $select_array[2] = 'UF_AUTO_969809737336'; // Уволенный сотрудник (ФИО)
                                        // $select_array[3] = 'UF_AUTO_958984612536'; // Уволенный сотрудник (ID)
                                    
                                        if (essence == 'companie') {
                                            if (new_user_id != 0) {
                                                data_array[common_count] = {method: table_methodes_array[main_count], params: {'ID' : essence_id, fields: {'ASSIGNED_BY_ID' : new_user_id, 'UF_CRM_1544552542' : '',
                                                'UF_CRM_1635138005' : main_user_id, 'UF_CRM_1635137984' : base_employee_name}}};
                                            }
                                        }
                                        else if (essence == 'contact') {
                                            if (new_user_id != 0) {
                                                data_array[common_count] = {method: table_methodes_array[main_count], params: {'ID' : essence_id, fields: {'ASSIGNED_BY_ID' : new_user_id, 'UF_CRM_1635104431' : '', 
                                                'UF_CRM_1635137593' : main_user_id, 'UF_CRM_1635137564' : base_employee_name}}};
                                            }
                                        }
                                        else if (essence == 'deal') {
                                            if (new_user_id != 0) {
                                                data_array[common_count] = {method: table_methodes_array[main_count], params: {'ID' : essence_id, fields: {'ASSIGNED_BY_ID' : new_user_id, 'UF_CRM_1635104330' : '', 
                                                'UF_CRM_1635138267' : main_user_id, 'UF_CRM_1635138236' : base_employee_name}}};
                                            }
                                        }
                                        else if (essence == 'task_resp') {
                                            if (new_user_id != 0) {
                                                data_array[common_count] = {method: table_methodes_array[main_count], params: {'taskId' : essence_id, fields: {'RESPONSIBLE_ID' : new_user_id, 'UF_AUTO_875680162853' : '',
                                                'UF_AUTO_969809737336' : base_employee_name, 'UF_AUTO_958984612536' : main_user_id}}};
                                            }
                                        }
                                        else if (essence == 'task_setter') {
                                            if (new_user_id != 0) {
                                                data_array[common_count] = {method: table_methodes_array[main_count], params: {'taskId' : essence_id, fields: {'CREATED_BY' : new_user_id, 'UF_AUTO_897821339906' : '',
                                                'UF_AUTO_969809737336' : base_employee_name, 'UF_AUTO_958984612536' : main_user_id}}};
                                            }
                                        }
                                        else if (essence == 'task_auditor') {
                                            if (new_user_id != 0) {
                                                auditors_array = table_obj.rows[row_count].cells[4].textContent.split(',');
                                                const index = auditors_array.indexOf(String(main_user_id));
                                                if (index != -1) {
                                                    auditors_array.splice(index, 1);
                                                }
                                                auditors_array[auditors_array.length] = new_user_id;
                                                data_array[common_count] = {method: table_methodes_array[main_count], params: {'taskId' : essence_id, fields: {'AUDITORS' : auditors_array, 'UF_AUTO_625870498471' : main_user_id, 
                                                'UF_AUTO_149878642279' : new_user_id, 'UF_AUTO_969809737336' : base_employee_name, 'UF_AUTO_958984612536' : main_user_id}}};
                                            }
                                        }
                                        
                                        
                                        //console.log('data_array: '); console.log(data_array);
                                        
                                    }

                                    common_count++;
                                }
                            }
                            
                            row_count++;
                        } //  for (let row of table_obj.rows)
                        
                    }  // for (var main_count = 0; main_count < table_ids_array.length; main_count++)
                    
                    //console.log('data_array: '); console.log(data_array);
                    //return false;

                    const ITEMS_IN_REQ = 50;
                    let data_batch_array = [];
                    let batch_count = 0;
                    let items_count = 0;

                    while (items_count < data_array.length) {
  
                        if (batch_count < ITEMS_IN_REQ) {
                            data_batch_array[batch_count] = data_array[items_count];
                            
                            if (items_count == data_array.length - 1) {
                                //console.log(data_batch_array);
                                BX24.callBatch(data_batch_array, function(result){
                                    if (app_mode == 1){
                                        alert('Дела переданы!');
                                    }
                                    else if (app_mode == 2){
                                        alert('Дела возвращены!');
                                    }
                                    else if (app_mode == 3){
                                        alert('Дела переданы и сотрудник уволен!');
                                    }                                    
                                    //console.log(result);
                                });
                            }
                            
                            batch_count++;
                        }
                        else {
                            //console.log(data_batch_array);
                            BX24.callBatch(data_batch_array, function(result){
                                if (items_count == data_array.length - 1) {
                                    if (app_mode == 1){
                                        alert('Дела переданы!');
                                    }
                                    else if (app_mode == 2){
                                        alert('Дела возвращены!');
                                    }
                                    else if (app_mode == 3){
                                        alert('Дела переданы и сотрудник уволен!');
                                    }   
                                }
                                //console.log(result);
                            });
                            data_batch_array = [];
                            batch_count = 0;
                            data_batch_array[batch_count] = data_array[items_count];
                            batch_count++;
                        }

                        items_count++;
                    }
                    
                    //console.log('data_batch_array: '); console.log(data_batch_array);
                    
                    return 0;

                } // end function change_resp_user
                
                function essenceses_list_former (companies_list_flag, deals_list_flag, activities_list_flag, tasks_resp_list_flag, tasks_setter_list_flag, tasks_auditor_list_flag, main_user_id, user_id_tmp, new_user_id, app_mode) {
                
                    try {
                
                        essence_data = essence_list_former('companies_table', 'companies_table_tbody', ((companies_list_flag == 0) ? 1 : 0), 'crm.company.list', main_user_id, user_id_tmp, new_user_id, 'companie', app_mode);
                        essence_data = tasks_list_former('tasks_resp_table', 'tasks_resp_table_tbody', ((tasks_resp_list_flag == 0) ? 1 : 0), 'tasks.task.list', main_user_id, user_id_tmp, new_user_id, 'task', app_mode);
                        essence_data = tasks_list_former('tasks_setter_table', 'tasks_setter_table_tbody', ((tasks_setter_list_flag == 0) ? 1 : 0), 'tasks.task.list', main_user_id, user_id_tmp, new_user_id,  'task', app_mode);
                        essence_data = tasks_list_former('tasks_auditor_table', 'tasks_auditor_table_tbody', ((tasks_auditor_list_flag == 0) ? 1 : 0), 'tasks.task.list', main_user_id, user_id_tmp, new_user_id,  'task', app_mode);
                        return essence_data;
                    
                    }
                    catch (e) {
                        console.log(e);
                    }
                }

                function tasks_list_former (table_id, table_body_id, task_list_flag, method, main_user_id, user_id_tmp, new_user_id, essence, app_mode) {
                
                    // $select_array[0] = 'UF_AUTO_517665449295'; // Предыдущий ответственный (ФИО)
                    // $select_array[1] = 'UF_AUTO_875680162853'; // Предыдущий ответственный (ID)
                    // $select_array[6] = 'UF_AUTO_807773390305'; // Предыдущий постановщик (ФИО)
                    // $select_array[7] = 'UF_AUTO_897821339906'; // Предыдущий постановщик (ID)
                    // $select_array[2] = 'UF_AUTO_969809737336'; // Уволенный сотрудник (ФИО)
                    // $select_array[3] = 'UF_AUTO_958984612536'; // Уволенный сотрудник (ID)
                    // $select_array[4] = 'UF_AUTO_406164185840'; // Предыдущий аудитор (ФИО)
                    // $select_array[5] = 'UF_AUTO_625870498471'; // Предыдущий аудитор (ID)
                
                    try {

                        let user_type;
                        let fields_array = {}; let select_array = {};
                        
                        if (main_user_id != '' && main_user_id != 0) {
                        
                            if (app_mode == 1 || app_mode == 3){

                                if (table_id == 'tasks_resp_table') {
                                    fields_array = {filter : {'RESPONSIBLE_ID' : main_user_id, '!REAL_STATUS' : '5'}};
                                }    
                                else if (table_id == 'tasks_setter_table'){
                                    fields_array = {filter : {'CREATED_BY' : main_user_id, '!REAL_STATUS' : '5'}};
                                }
                                else if (table_id == 'tasks_auditor_table'){
                                    fields_array = {filter : {'AUDITOR' : main_user_id, '!REAL_STATUS' : '5'}};
                                }
                                
                            }
                            else if (app_mode == 2){

                                if (table_id == 'tasks_resp_table') {
                                    fields_array = {filter : {'UF_AUTO_875680162853' : main_user_id, '!REAL_STATUS' : '5'}};
                                }    
                                else if (table_id == 'tasks_setter_table'){
                                    fields_array = {filter : {'UF_AUTO_897821339906' : main_user_id, '!REAL_STATUS' : '5'}};
                                }
                                else if (table_id == 'tasks_auditor_table'){
                                    //select_array = {0 : 'UF_AUTO_149878642279', 1 : 'TITLE', 2 : 'ID', 3 : 'UF_AUTO_625870498471'};
                                    fields_array = {filter : {'UF_AUTO_625870498471' : main_user_id, '!REAL_STATUS' : '5'}, 
                                    select : {0 : 'UF_AUTO_149878642279', 1 : 'TITLE', 2 : 'ID', 3 : 'UF_AUTO_625870498471', 4 : 'AUDITORS'}};
                                }

                            }
                            

                            let common_count = 0;
                            if (main_user_id != user_id_tmp) {
                                user_id_tmp = main_user_id;
                            }
                            $('#' + table_id +' tbody').empty();

                            BX24.callMethod(method, fields_array, function(result){

                                if(result.data()){
                                    let essence_array = (essence == 'task') ? result.data()['tasks'] : result.data();
                                    let essence_item;
                                    let table_row;
                                    let essence_name;
                                    let essence_id;
                                    let essence_check_name;
                                    let essence_auditors;
                                    let replaced_auditor;
                                    let main_count = 0;
                                    while (main_count < essence_array.length) {
                                        essence_item = essence_array[main_count];
                                        essence_name = essence_item['title'];
                                        essence_id = essence_item['id'];
                                        if (table_id == 'tasks_resp_table') {
                                            essence_check_name = 'tasks_resp';
                                        }
                                        else if (table_id == 'tasks_setter_table') {
                                            essence_check_name = 'tasks_setter';
                                        }
                                        else if (table_id == 'tasks_auditor_table') {
                                            essence_check_name = 'tasks_auditor';
                                        }
                                        
                                        if (table_id == 'tasks_auditor_table'){
                                            
                                            //console.log(essence_item);
                                            essence_auditors = essence_item['auditors'];
                                            replaced_auditor = essence_item['ufAuto149878642279'];
                                            
                                            if (replaced_auditor == 'undefined'){
                                                replaced_auditor = 'null';
                                            }
                                            
                                            //console.log(replaced_auditor);
                                            
                                            table_row = '<tr class="tr_class">' + 
                                            '<td class="td_class"><input name="' + essence_check_name + 's" id="' + essence_check_name + '_' + essence_id + '" type="checkbox"></td>' + 
                                            '<td class="td_class">' + (common_count + 1) + '</td>' + 
                                            '<td class="td_class">' + essence_id + '</td>' + 
                                            '<td class="td_class">' + essence_name + '</td>' +
                                            '<td class="td_class" style="display: none;">' + essence_auditors.join(',') + '</td>' +
                                            '<td class="td_class" style="display: none;">' + replaced_auditor + '</td>' +
                                            '</tr>';
                                            $('#' + table_id +' tbody').append(table_row);
                                            //console.log(essence_item);
                                        }
                                        else {
                                            table_row = '<tr class="tr_class">' + 
                                            '<td class="td_class"><input name="' + essence_check_name + 's" id="' + essence_check_name + '_' + essence_id + '" type="checkbox"></td>' + 
                                            '<td class="td_class">' + (common_count + 1) + '</td>' + 
                                            '<td class="td_class">' + essence_id + '</td>' + 
                                            '<td class="td_class">' + essence_name + '</td>' +
                                            '</tr>';
                                            $('#' + table_id +' tbody').append(table_row);
                                            //console.log(essence_item); 
                                        }    
                                        main_count++;
                                        common_count++;
                                    } // while
                                    
                                    //console.log(result.data());
                                    
                                    if(result.more()){result.next()}
                                    
                                } // if(result.data())
                            
                                //console.log(result);
                                
                            });
                            
                            document.getElementById(table_body_id).style = (task_list_flag == 0) ? '' : 'display: none';

                        } // if (main_user_id != '')

                        return [((task_list_flag == 0) ? 1 : 0), user_id_tmp];

                    }
                    catch (e) {
                        console.log(e);
                    }


                } // function change_resp_user
                
                function essence_list_former (table_id, table_body_id, essence_list_flag, method, main_user_id, user_id_tmp, new_user_id, essence, app_mode) {
                    
                    if (main_user_id != '' && main_user_id != 0) {
                    
                        let last_users_array = new Map([
                            ['contact', 'UF_CRM_1620105374'],
                            ['companie', 'UF_CRM_1620058523'],
                            ['lead', 'UF_CRM_1620058211'],
                            ['deal', 'UF_CRM_1614182763'],
                            ['task_resp', 'UF_AUTO_170174400351'],
                            ['task_setter', 'UF_AUTO_829346814964']
                        ]);
                        
                        /*let last_users_array_real = new Map([
                            ['contact', 'UF_CRM_1635104431'],
                            ['companie', 'UF_CRM_1544552542'],
                            ['lead', 'UF_CRM_1635104131'],
                            ['deal', 'UF_CRM_1635104330'],
                            ['task_resp', 'UF_AUTO_628462147682'],
                            ['task_setter', 'UF_AUTO_172995278717']
                        ]);*/
                        
                        //'<td class="td_class">' + custom_value_name_return('UF_CRM_1630589629', essence_item['UF_CRM_1630589629'], company_userfields_array) + '</td>' +
                        //'<td class="td_class">' + custom_value_name_return('UF_CRM_1630589843', essence_item['UF_CRM_1630589843'], company_userfields_array) + '</td>' +
                        //'<td class="td_class">' + custom_value_name_return('UF_CRM_1631019073', essence_item['UF_CRM_1631019073'], company_userfields_array) + '</td>' +

                        let user_type;
                        let fields_array = {};

                        if (app_mode == 1 || app_mode == 3) {
                            if (essence == 'contact') {
                                fields_array = {filter : {'ASSIGNED_BY_ID' : main_user_id}};
                            }
                            else if (essence == 'companie') {
                                fields_array = {select: {0 : 'ID', 1 : 'TITLE', 2 : 'UF_CRM_1602193367', 3 : 'UF_CRM_1602193556', 4 : 'UF_CRM_1602193537', 5 : 'UF_CRM_1630589629',
                                6 : 'UF_CRM_1630589843', 7 : 'UF_CRM_1631019073'}, 
                                filter: {'ASSIGNED_BY_ID' : main_user_id}};
                            }
                            else if (essence == 'lead') {
                                fields_array = {filter : {'ASSIGNED_BY_ID' : main_user_id, 'STATUS_SEMANTIC_ID' : 'P'}};
                            }
                            else if (essence == 'deal') {
                                fields_array = {filter : {'ASSIGNED_BY_ID' : main_user_id, 'CLOSED' : 'N'}};
                            }
                            else if (essence == 'activity') {
                                fields_array = {filter : {'OWNER_ID' : main_user_id, 'CLOSED' : 'N'}};
                            }                            
                        }
                        else if (app_mode == 2) {
                            if (essence == 'contact') {
                                fields_array = {filter : {'UF_CRM_1635104431' : main_user_id}};
                            }
                            else if (essence == 'companie') {
                                fields_array = {select: {0 : 'ID', 1 : 'TITLE', 2 : 'UF_CRM_1602193367', 3 : 'UF_CRM_1602193556', 4 : 'UF_CRM_1602193537', 5 : 'UF_CRM_1630589629',
                                6 : 'UF_CRM_1630589843', 7 : 'UF_CRM_1631019073', 8: 'UF_CRM_1544552542'}, 
                                filter: {'UF_CRM_1544552542' : main_user_id}};
                            }
                            else if (essence == 'lead') {
                                fields_array = {filter : {'UF_CRM_1635104131' : main_user_id, 'STATUS_SEMANTIC_ID' : 'P'}};
                            }
                            else if (essence == 'deal') {
                                fields_array = {filter : {'UF_CRM_1635104330' : main_user_id, 'CLOSED' : 'N'}};
                            }
                            else if (essence == 'activity') {
                                fields_array = {filter : {'OWNER_ID' : main_user_id, 'CLOSED' : 'N'}};
                            }
                        }
                            
                        //console.log(fields_array);
                        //console.log(company_userfields_array);
                        //console.clear();
                        
                        //console.log(main_user_id);

                        //let field_value;
                        //field_value = custom_value_name_return('UF_CRM_1602193367', '385', company_userfields_array);
                        //console.log(field_value);
                        //console.log(custom_fields_list_array);

                        // Essence list //      

                        let common_count = 0;
                        if (main_user_id != user_id_tmp) {
                            user_id_tmp = main_user_id;
                        }
                        $('#' + table_id +' tbody').empty();
                        
                        
                        //console.log(essence);
                        
                        const DELAY_NEXT_DATA_MS = 100;

                        BX24.callMethod(method, fields_array, function(result){

                            if(result.data()){
                                let essence_array = (essence == 'task') ? result.data()['tasks'] : result.data();
                                let essence_item;
                                let table_row;
                                let essence_name;
                                let essence_id;
                                let essence_check_name;
                                let main_count = 0;
                                
                                while (main_count < essence_array.length) {
                                    essence_item = essence_array[main_count];
                                    if (essence == 'companie' || essence == 'deal' || essence == 'lead') {
                                        essence_name = essence_item['TITLE'];
                                        essence_id = essence_item['ID'];
                                        essence_check_name = essence;
                                    }
                                    else if (essence == 'contact'){
                                        essence_check_name = 'contact';
                                        essence_name = essence_item['NAME'];
                                        essence_id = essence_item['ID'];
                                    }
                                    else if (essence == 'activity'){
                                        essence_check_name = 'activity';
                                        essence_name = essence_item['SUBJECT'];
                                        essence_id = essence_item['ID'];
                                        //console.log('essence_item: ' + essence_item);
                                    }
                                    
                                    let deal_summ = 0;
                                    let closed_status = 0;
                                    
                                    if (essence == 'deal') {
                                        deal_summ = essence_item['OPPORTUNITY'];
                                        closed_status = essence_item['STAGE_ID'];
                                        console.log(essence_item);
                                        table_row = '<tr class="tr_class">' + 
                                        '<td class="td_class"><input name="' + essence_check_name + 's" id="' + essence + '_' + essence_id + '" type="checkbox" checked="checked"></td>' + 
                                        '<td class="td_class">' + (common_count + 1) + '</td>' + 
                                        '<td class="td_class">' + essence_id + '</td>' + 
                                        '<td class="td_class">' + '<a target="_blank" href="https://crm.galtsystems.ru/crm/deal/details/' + essence_id + '/">' + essence_name + '</a>' + '</td>' +
                                        '<td class="td_class">' + deal_summ + '</td>' +
                                        '<td class="td_class">' + closed_status + '</td>' +
                                        '</tr>';
                                        
                                    }
                                    else if (essence == 'companie') {
                                    
                                        //console.log(essence_item);
                                    
                                        table_row = '<tr class="tr_class">' + 
                                        '<td class="td_class" style="width: 40px;"><input name="' + essence_check_name + 's" id="' + essence + '_' + essence_id + '" type="checkbox" class="company" onclick="company_click();"></td>' + 
                                        '<td class="td_class" style="width: 40px;">' + (common_count + 1) + '</td>' + 
                                        '<td class="td_class" style="width: 60px;">' + essence_id + '</td>' + 
                                        '<td class="td_class" style="width: 180px;">' + '<a target="_blank" href="https://crm.galtsystems.ru/crm/company/details/' + essence_id + '/">' + essence_name + '</a>' + '</td>' +
                                        '<td class="td_class" style="width: 120px;">' + custom_value_name_return('UF_CRM_1602193367', essence_item['UF_CRM_1602193367'], company_userfields_array) + '</td>' +
                                        '<td class="td_class" style="width: 100px;">' + custom_value_name_return('UF_CRM_1602193537', essence_item['UF_CRM_1602193537'], company_userfields_array) + '</td>' +
                                        '<td class="td_class" style="width: 100px;">' + essence_item['UF_CRM_1602193556'] + '</td>' +
                                        '<td class="td_class" style="width: 100px;">' + custom_value_name_return('UF_CRM_1630589629', essence_item['UF_CRM_1630589629'], company_userfields_array) + '</td>' +
                                        '<td class="td_class" style="width: 100px;">' + custom_value_name_return('UF_CRM_1630589843', essence_item['UF_CRM_1630589843'], company_userfields_array) + '</td>' +
                                        '<td class="td_class" style="width: 90px;">' + custom_value_name_return('UF_CRM_1631019073', essence_item['UF_CRM_1631019073'], company_userfields_array) + '</td>' +
                                        '</tr>';
                                        
                                    }
                                    
                                    else if (essence == 'activity') {
                                    
                                        //console.log(essence_item);
                                    
                                        table_row = '<tr class="tr_class">' + 
                                        '<td class="td_class"><input name="' + 'activities" id="' + essence + '_' + essence_id + '" type="checkbox"></td>' + 
                                        '<td class="td_class">' + (common_count + 1) + '</td>' + 
                                        '<td class="td_class">' + essence_id + '</td>' + 
                                        '<td class="td_class">' + '<a target="_blank" href="https://crm.galtsystems.ru/crm/activity/' + essence_id + '/">' + essence_name + '</a>' + '</td>' +
                                        '</tr>';
                                        
                                    }
                                    
                                    else if (essence == 'contact'){
                                        
                                        table_row = '<tr class="tr_class">' + 
                                        '<td class="td_class"><input name="' + essence_check_name + 's" id="' + essence + '_' + essence_id + '" type="checkbox"></td>' + 
                                        '<td class="td_class">' + (common_count + 1) + '</td>' + 
                                        '<td class="td_class">' + essence_id + '</td>' + 
                                        '<td class="td_class">' + '<a target="_blank" href="https://crm.galtsystems.ru/crm/contact/details/' + essence_id + '/">' + essence_name + '</a>' + '</td>' +
                                        '</tr>';
                                        
                                    }                                    
                                    
                                    else {
                                        
                                        table_row = '<tr class="tr_class">' + 
                                        '<td class="td_class"><input name="' + essence_check_name + 's" id="' + essence + '_' + essence_id + '" type="checkbox"></td>' + 
                                        '<td class="td_class">' + (common_count + 1) + '</td>' + 
                                        '<td class="td_class">' + essence_id + '</td>' + 
                                        '<td class="td_class">' + essence_name + '</td>' +
                                        '</tr>';
                                        
                                    }
                                    
                                    //https://crm.galtsystems.ru/crm/deal/details/14782/
                                    
                                    // activities_table
                                      
                                    $('#' + table_id +' tbody').append(table_row);
                                    //console.log(essence_item);
                                    main_count++;
                                    common_count++;
                                } // while
                                
                                //console.log(result.data());
                                
                                setTimeout(function(){
                                    if(result.more()){result.next()}
                                }, DELAY_NEXT_DATA_MS);
                                
                            } // if(result.data())

                        });
                        
                        document.getElementById(table_body_id).style = (essence_list_flag == 0) ? '' : 'display: none';
                        
                    } // if (main_user_id != '')
                    else {
                        //alert('Выберите сотрудника!');
                    }

                    return [((essence_list_flag == 0) ? 1 : 0), user_id_tmp];

                } // function essence_list_former

                function company_common_click () {
                    try {
                        common_checkboxes('common_companies', 'companies');
                        let batch_event = new Event("click"); batch_start.dispatchEvent(batch_event);
                    }
                    catch (e) {
                       console.log(e);
                    }
                }
                
                function company_click () {
                    
                    try {
                        document.getElementById('common_companies').checked = false;
                        let batch_event = new Event("click"); batch_start.dispatchEvent(batch_event);
                    }
                    catch (e) {
                       console.log(e);
                    }
                }
                
                // Deals //
                
                function deals_list_former(deals_array, app_mode) {
                
                    try {
                
                        let deals_table_id = 'deals_table';
                        $('#' + deals_table_id +' tbody').empty();
                        let deal_id; let table_row; let deal_summ = 0; let deal_name;
                        for (let deals_count = 0; deals_count < deals_array.length; deals_count++) {      
                            deal_id = deals_array[deals_count].ID;
                            deal_summ = deals_array[deals_count].OPPORTUNITY;
                            deal_name = deals_array[deals_count].TITLE;
                            table_row = '<tr class="tr_class">' + 
                            '<td class="td_class"><input name="' + 'deal' + 's" id="' + 'deal_' + '_' + deal_id + '" type="checkbox" checked="checked" disabled="disabled"></td>' + 
                            '<td class="td_class">' + (deals_count + 1) + '</td>' + 
                            '<td class="td_class">' + deal_id + '</td>' + 
                            '<td class="td_class">' + '<a target="_blank" href="https://crm.galtsystems.ru/crm/deal/details/' + deal_id + '/">' + deal_name + '</a>' + '</td>' +
                            '<td class="td_class">' + deal_summ + '</td>' +
                            '</tr>';
                            $('#' + deals_table_id +' tbody').append(table_row);
                        }

                    }
                    catch (e) {
                        console.log(e);
                    }
                }
                
                function companies_ids_for_deals_array_former(table_obj, checkboxes) {
                    
                    try {
                
                        let companies_ids_array = []; let deals_id_batch_array = []; let row_count = 0; let item_count = 0;
                        for (let row of table_obj.rows) {
                            if (row_count > 0) {
                                if (checkboxes[row_count - 1].checked) {
                                    companies_ids_array[item_count] = table_obj.rows[row_count].cells[2].textContent;
                                    deals_id_batch_array[item_count] = {method: 'crm.deal.list', params: {'filter' : {'COMPANY_ID' : table_obj.rows[row_count].cells[2].textContent}}};
                                    item_count++;
                                }
                            }
                            row_count++;
                        }
                        return deals_id_batch_array;                        
                    }
                    catch (e) {
                       console.log(e);
                       return -1;
                    }
                }
                
                function deals_id_array_former(batch_result, deals_array) {
                    
                    try {
                        
                        let common_deals_count = (deals_array.lenght != 0) ? deals_array.length : 0;
                        let deals_array_tmp = deals_array;
                        
                        let deals_data_result_batch_array = batch_result;
                        
                        //console.log('deals_data_result_batch_array: '); console.log(deals_data_result_batch_array);
                        //console.log('deals_data_result_batch_array: '); console.log(deals_data_result_batch_array.length);
                        
                        for (let deals_count = 0; deals_count < deals_data_result_batch_array.length; deals_count++) {
                            
                            //console.log(deals_data_result_batch_array[deals_count].data()[0]);
                            
                            if (deals_data_result_batch_array[deals_count].data().length != 0) {
                                deals_array_tmp[common_deals_count] = deals_data_result_batch_array[deals_count].data()[0];
                                common_deals_count++;
                            }
                        }

                        return deals_array_tmp;
                    
                    }
                    catch (e) {
                       console.log(e);
                       return -1;
                    }
                }
                
                // Contacts //
                
                function contacts_list_former(contacts_ids_array, app_mode) {
                
                    try {
                
                        let contacts_table_id = 'contacts_table';
                        $('#' + contacts_table_id +' tbody').empty();
                        
                        if (contacts_ids_array.lenght != 0){
                        
                            let contact_id; let table_row;
                            for (let contacts_count = 0; contacts_count < contacts_ids_array.length; contacts_count++) {      
                                contact_id = contacts_ids_array[contacts_count];
                                table_row = '<tr class="tr_class">' + 
                                '<td class="td_class"><input name="' + 'Контакт ' + contact_id + 's" id="' + 'contact_' + '_' + contact_id + '" type="checkbox" checked="checked" disabled="disabled"></td>' + 
                                '<td class="td_class">' + (contacts_count + 1) + '</td>' + 
                                '<td class="td_class">' + contact_id + '</td>' + 
                                '<td class="td_class">' + '<a target="_blank" href="https://crm.galtsystems.ru/crm/contact/details/' + contact_id + '/">' + 'Контакт ' + contact_id + '</a>' + '</td>' +
                                '</tr>'; 
                                $('#' + contacts_table_id +' tbody').append(table_row);
                            }
                        }    

                    }
                    catch (e) {
                        console.log(e);
                    }
                }
                
                function companies_ids_for_contacts_array_former(table_obj, checkboxes) {
                    
                    try {
                
                        let companies_ids_array = []; let contacts_id_batch_array = []; let row_count = 0; let item_count = 0;
                        for (let row of table_obj.rows) {
                            if (row_count > 0) {
                                if (checkboxes[row_count - 1].checked) {
                                    companies_ids_array[item_count] = table_obj.rows[row_count].cells[2].textContent;
                                    contacts_id_batch_array[item_count] = {method: 'crm.company.contact.items.get', params: {'ID' : table_obj.rows[row_count].cells[2].textContent}};
                                    item_count++;
                                }
                            }
                            row_count++;
                        }
                        return contacts_id_batch_array;                        
                    }
                    catch (e) {
                       console.log(e);
                       return -1;
                    }
                }
                
                function contacts_id_array_former(batch_result, contacts_ids_array) {
                    
                    try {
                        
                        let common_contacts_count = (contacts_ids_array.lenght != 0) ? contacts_ids_array.length : 0;
                        let contacts_ids_array_tmp = contacts_ids_array;
                        let contacts_by_company_id_array = batch_result;
                        for (let companies_count = 0; companies_count < contacts_by_company_id_array.length; companies_count++) {
                            let company_buffer = contacts_by_company_id_array[companies_count].data();
                            for (let contacts_count = 0; contacts_count < company_buffer.length; contacts_count++) {
                                contacts_ids_array_tmp[common_contacts_count] = company_buffer[contacts_count].CONTACT_ID;
                                common_contacts_count++;
                            }
                        }

                        return contacts_ids_array_tmp;
                    
                    }
                    catch (e) {
                       console.log(e);
                       return -1;
                    }
                }
                
                function batch_pack_array_former (batch_line_array) {
                    
                    try {
                        
                        const ITEMS_IN_REQ = 50;
                        let pack_batch_array = [];
                        let batch_count = 0;
                        let items_count = 0;
                        let batch_items_count = 0;
                        pack_batch_array[0] = [];
                        while (items_count < batch_line_array.length) {
                            if (batch_items_count < ITEMS_IN_REQ) {
                                pack_batch_array[batch_count][batch_items_count] = batch_line_array[items_count];
                                batch_items_count++;
                            }
                            else {
                                batch_count++; batch_items_count = 0;
                                pack_batch_array[batch_count] = [];
                                pack_batch_array[batch_count][batch_items_count] = batch_line_array[items_count];
                            }
                            //console.log('batch_count: '); console.log(batch_count);
                            items_count++;
                            
                        }
                        
                        return pack_batch_array;
                    
                    }
                    catch (e) {
                       console.log(e);
                       return -1;
                    }
                }
                
                
                function custom_value_name_return(FIELD_NAME, FILED_VALUE_ID, userfields_array) {
                
                    try {
                    
                        let custom_field_name; let custom_fields_list_array;
                        for (let fields_count = 0; fields_count < userfields_array.length; fields_count++) {
                            custom_field_name = userfields_array[fields_count]['FIELD_NAME']; 
                            if (custom_field_name == FIELD_NAME) {
                                custom_fields_list_array = userfields_array[fields_count]['LIST'];
                            }
                        }

                        let fields_list_array = [];
                        for (let fields_count = 0; fields_count < custom_fields_list_array.length; fields_count++) {
                            fields_list_array[custom_fields_list_array[fields_count]['ID']] = custom_fields_list_array[fields_count]['VALUE'];
                        }

                        return fields_list_array[FILED_VALUE_ID];
                    }
                    catch (e) {
                       return -1;
                    }
                    
                } // function custom_value_name_return
                
                function common_checkboxes(main_check_id, others_check_name) {
                    let item_checkboxes = document.getElementsByName(others_check_name);
                    for (var i = 0; i < item_checkboxes.length; i++) {
                        item_checkboxes[i].checked = (document.getElementById(main_check_id).checked) ? true : false; // ($(this).is(':checked'))
                    }
                }