// custom js

var persons = {
    dataSource: '/data/' + jsonFile,
    forceLocked: false,
    // graphWidth: function () {
    //     return 600;
    // },
    graphHeight: function () {
        return 400;
    },
    linkDistance: function () {
        return 40;
    },
    nodeTypes: {
        "node_type": ["Maintainer", "Contributor"]
    },
    nodeCaption: function (node) {
        return node.name + " (" + node.years + ") ";
    },

    nodeMouseOver: function (node) {
        var wiki = node.getProperties('wiki');
        var name = node.getProperties('name');
        $('#person').html(name);
        if (wiki.length < 2) {
            $('#message').html('<p class="text-danger">Sorry, geen wiki link voor deze persoon.</p>');
        } else {
            $('#message').html('<p class="text-success">Portretten van ' + name + ' worden geladen....</p>');
            loadImages('/api.php?uri=' + wiki, '#personPics');
        }
    }
};
alchemy = new Alchemy(persons);


// image loading utils
function loadImages(url, container) {
    console.log(loading);
    if (loading) {
        return false;
    }
    clearImages(container);

    if (!loading) {
        loading = true;
        $.getJSON(url, function (json) {
            var hits = json.hits;
            var imgList = '';
            $.each(json.records, function () {
                imgList += createCard(this);
            });

            if (imgList.length < 1) {
                $('#message').html('<p class="text-danger">Sorry, geen foto\'s gevonden.');
            } else {
                $(container).append(imgList);
                $('#message').html('');
            }
            loading = false;
        });
    }
};

function clearImages(container) {
    $(container).empty();
}

function createCard(item) {
    var html =
        '<div class="d-inline-flex" style="width: 160px;">' +
        '<a href="' + item.url + '" data-title="' + item.title + '" data-footer="' +
        '<br/><a href=\'' + item.url + '\' target=\'_blank\'>Bekijk</a>" ' +
        'data-toggle="lightbox" data-gallery="street">' +
        '<img width="200" class="img-thumbnail" src="' + item.img + '" alt="portret" ' +
        'data-toggle="tooltip" data-placement="top" title="' + item.title + '"></a>' +
        '</div>';
    return html;
}