
jQuery(document).ready(function(){
    bindPaginationLinks();
});

function bindPaginationLinks(){
    let pageLinks = jQuery(".pagination a");
    if(pageLinks.length == 0) return;
    pageLinks.each(function(index){
        jQuery(this).on('click', onPaginationClick);
    });
}
function onPaginationClick(e){
    e.preventDefault();
    let link = jQuery(this)[0];
    jQuery.get(link.href, function(data){
        jQuery(link.dataset.target).replaceWith(data);
        bindPaginationLinks();
    });
}
