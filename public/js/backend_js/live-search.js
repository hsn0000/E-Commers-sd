
liveSearch = {
    init: function($path,$placeholder='Search for a item',$id){
        if($("select.live-search")[0]) {
            var e=$(".select2-parent")[0]?$(".select2-parent"): $("body"),$elem=$id?$('#'+$id):$("select.live-search");
            $elem.select2({
                dropdownAutoWidth: !0, width: "100%",
                ajax: {
                    url: $('base').attr('href')+$path,
                    method: 'post',
                    dataType: 'json',
                    delay: 400,
                    data: function (params) {
                        var query = {
                            _token: $('meta[name=csrf-token]').attr('content'),
                            search: params.term,
                            page: params.page,
                            selected: function(){
                                var selected_text = '';
                                $('select.live-search option:selected').each(function() {
                                    if($(this).val()){
                                        selected_text += $(this).val() + ",";
                                    }
                                });
                                return selected_text.replace(/^,|,$/g,'')
                            }
                        }

                        return query;
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 10) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                placeholder: $placeholder,
                minimumInputLength: 1,
                // templateResult: formatRepo,
                // templateSelection: formatRepoSelection
            });
        }
    }
}

$(document).ready(function() {

});

function formatRepo (repo) {
    if (repo.loading) {
      return repo.text;
    }
    var $container = $(
    "<div class='select2-result-data clearfix'>" +
        "<div class='select2-result-data__meta'>" +
        "<div class='select2-result-data__text'></div>" +
        "</div>" +
    "</div>"
    );

    $container.find(".select2-result-data__text").text(repo.text);

    return $container;
}

function formatRepoSelection (repo) {
  return repo.text;
}
