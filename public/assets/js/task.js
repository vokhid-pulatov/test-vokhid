/**
 *
 * @param task_name
 */
function addTask(task_name)
{
    $.post('/add_task', {'task_name': task_name},
        function(response){
            if (response.success === true) {
                $('#tasks_list').html(response.html);
            }
            else {

            }
        },
        'json');
}

/**
 *
 * @param task_name
 * @param task_id
 */
function showEditForm(task_name, task_id)
{
    $('#edit_form').show();
    $('.edited_task_name').val(task_name);
    $('.edited_task_name').attr('id', task_id);

}

/**
 *
 */
function editTask()
{
    var new_task_name = $('.edited_task_name').val();
    var new_task_id = $('.edited_task_name').attr('id');
    $.post('/edit_task', {'task_name': new_task_name, 'task_id': new_task_id},
        function(response){
            if (response.success === true) {
                $('#tasks_list').html(response.html);
            }
            else {

            }
        },
        'json');
}

/**
 *
 * @param task_id
 */
function deleteTask(task_id)
{
    $.post('/delete_task', {'task_id': task_id},
        function(response){
            if (response.success === true) {
                $('#tasks_list').html(response.html);
            }
            else {
                alert(response.success);
            }
        },
        'json');
}