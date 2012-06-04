/**
 * Overriding core submitbutton task to perform our onsubmit function
 * without submitting form afterwards
 * for J1.6+
 * 
 * On any pages that require ajax form validation, add this:
 * JHTML::_('script', 'validation.js', 'media/dioscouri/js/');
 * 
 * @param task
 * @return
 */
Joomla.submitform = function(task, form) {
    if (typeof(form) === 'undefined') {
        form = document.getElementById('adminForm');
        /**
         * Added to ensure Joomla 1.5 compatibility
         */
        if(!form){
            form = document.adminForm;
        }
    }

    if (typeof(task) !== 'undefined' && '' !== task) {
        form.task.value = task;
    }

    // Submit the form.
    if (typeof form.onsubmit == 'function') {
        form.onsubmit();
    }
    if (typeof form.fireEvent == 'function') {
        form.fireEvent('submit');
    }

};