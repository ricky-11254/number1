jQuery(document).ready(function($) {

  'use strict';

  //Render the markdown content based on the textarea value
  const textareaValue = $('#content').val();
  renderMarkdown(textareaValue);

  //Dialog Confirm ---------------------------------------------------------------------------------------------------
  window.DAEXTULMA = {};
  $(document.body).on('click', '.menu-icon.delete', function(event) {

    'use strict';

    event.preventDefault();
    window.DAEXTULMA.documentToDelete = $(this).prev().val();
    $('#dialog-confirm').dialog('open');

  });

  //Render the markdown text in the render section on the input event of the textarea
  $('#content').on('input', function() {

    'use strict';

    const textareaValue = $(this).val();
    renderMarkdown(textareaValue);

  });

  //Render the Markdown text in the editor render
  function renderMarkdown(textareaValue) {

    'use strict';

    /**
     * Remove the YAML data available at the beginning of the document (Front
     * Matter)
     */
    const textWithoutFrontMatter = textareaValue.replace(/-{3}.+?-{3}/ms, '');

    //Generate the HTML from the Markdown content
    const content = marked(textWithoutFrontMatter);

    //Sanitize the generated HTML
    let cleanContent = DOMPurify.sanitize(content,
        {USE_PROFILES: {html: true}});

    //Add the HTML in the DOM
    $('#editor-render').html(cleanContent);

  }

  /**
   * Dialog confirm initialization.
   */
  $(function() {

    'use strict';

    $('#dialog-confirm').dialog({
      autoOpen: false,
      resizable: false,
      height: 'auto',
      width: 340,
      modal: true,
      buttons: {
        [objectL10n.deleteText]: function() {

          'use strict';

          $('#form-delete-' + window.DAEXTULMA.documentToDelete).submit();

        },
        [objectL10n.cancelText]: function() {

          'use strict';

          $(this).dialog('close');

        },
      },
    });

  });

});