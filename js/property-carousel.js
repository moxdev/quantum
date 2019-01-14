// Carousel
var elem = document.querySelector( '.floorplans-gallery' );
var flkty = new Flickity( elem, {
  contain: true,
  pageDots: false,
  setGallerySize: false,
  groupCells: true
});

jQuery( document ).ready( function() {
  jQuery( 'a[data-imagelightbox="a"]' ).imageLightbox({
    activity: true,
    animationSpeed: 250,
    arrows: true,
    button: true,
    caption: true,
    overlay: true
  });
});
