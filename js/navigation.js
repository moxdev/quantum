// IE Polyfill
// http://tips.tutorialhorizon.com/2017/01/06/object-doesnt-support-property-or-method-foreach/
( function() {
  if ( 'function' === typeof NodeList.prototype.forEach ) {
    return false;
  }
  NodeList.prototype.forEach = Array.prototype.forEach;
}() );

( function() {

  // Variables we will need
  const btn = document.querySelector( '.mobile-menu-toggle' );
  const nav = document.getElementById( 'mobile-navigation' );
  const page = document.body;
  const content = document.getElementById( 'content' );
  const footer = document.getElementById( 'colophon' );
  const mobileNavAnchors = document.querySelectorAll( '#mobile-main a' );
  const desktopNavAnchors = document.querySelectorAll( '#desktop-main .main-menu a' );
  const activeClass = 'nav-open';

  // Calculate what the padding for the top of the panel should be
  function navPadding() {
    const topPadding = document.getElementById( 'masthead' ).clientHeight;
    nav.style.height = `${window.innerHeight - topPadding}px`;
  }

  // Toggle button text and aria controls, toggle a class on elem, hide all other elements that are passed in the arguments
  function toggleNav( btn, elem, ...items ) {
    if ( elem.classList.contains( activeClass ) ) {
      items.forEach( ( item ) => {
        item.style.display = 'block';
      });
      nav.addEventListener( 'transitionend', () => {
        btn.setAttribute( 'aria-expanded', 'false' );
      }, { once: true });
    } else {
      nav.addEventListener( 'transitionend', () => {
        items.forEach( ( item ) => {
          item.style.display = 'block';
        });
        btn.setAttribute( 'aria-expanded', 'true' );
      }, { once: true });
    }

    btn.classList.toggle( activeClass );
    elem.classList.toggle( activeClass );
  }

  function toggleDropDowns( item ) {
    item.classList.toggle( activeClass );
    if ( item.nextElementSibling.classList.contains( activeClass ) ) {
      item.nextElementSibling.style.maxHeight = 0;
      setTimeout(
        function() {
          item.nextElementSibling.classList.remove( activeClass );
        },
        500
      );
    } else {
      item.nextElementSibling.classList.add( activeClass );
      item.nextElementSibling.style.maxHeight = item.nextElementSibling.scrollHeight +
        'px';
    }
  }

  // Toggle individual nav menus
  mobileNavAnchors.forEach( ( item ) => {
    item.addEventListener( 'click', function( evt ) {
      const hrefStr = item.href.split( '' );
      if ( '#' == hrefStr[hrefStr.length - 1]) {
        evt.preventDefault();
        toggleDropDowns( item );
      }
    });
  });

  desktopNavAnchors.forEach( ( item ) => {
    item.addEventListener( 'click', function( evt ) {
      const hrefStr = item.href.split( '' );
      if ( '#' == hrefStr[hrefStr.length - 1]) {
        evt.preventDefault();
        toggleDropDowns( item );
      }
    });
  });

  /***** TOGGLE SUBMENUS ******/
  const arrows = [ ...document.querySelectorAll( '.arrow' ) ];
  arrows.forEach( element => {
    element.addEventListener( 'click', toggleSubMenu );
  });

  function toggleSubMenu() {
    if ( 0 == this.nextElementSibling.style.maxHeight ) {
      this.nextElementSibling.classList.add( 'nav-open' );
      setTimeout( () => {
        this.nextElementSibling.style.maxHeight = this.nextElementSibling.scrollHeight + 'px';
      }, 100 );
    } else {
      this.nextElementSibling.style.maxHeight = this.nextElementSibling.style.maxHeight = null;
      setTimeout( () => {
        this.nextElementSibling.classList.remove( 'nav-open' );
      }, 275 );
    }
    this.classList.toggle( 'nav-open' );
  }

  // Event listeners
  window.addEventListener( 'load', navPadding );
  window.addEventListener( 'resize', navPadding );

  btn.addEventListener( 'click', function() {
    toggleNav( this, page, content, footer );
  });

}() );
