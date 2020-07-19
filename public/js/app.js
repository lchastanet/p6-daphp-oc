$(document).ready(() => {
    let $collectionHolder = $('div.videos')
    let $addButton = $('<a class="btn btn-primary" class="add_tag_link">Ajouter une video</a>')
    
    $collectionHolder.after($addButton)

    function addTagForm($collectionHolder) {
        let index = $collectionHolder.data('index')
        let newForm = $collectionHolder.data('prototype').replace(/__name__/g, index)
    
        $collectionHolder.data('index', index + 1).append(newForm)
    }

    $collectionHolder.data('index', $collectionHolder.find('input').length)

    $addButton.on('click', () => { addTagForm($collectionHolder) })
})