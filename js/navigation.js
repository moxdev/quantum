// Array.from() polyfill
if ( ! Array.from ) {
  Array.from = ( function() {
    var toStr = Object.prototype.toString;
    var isCallable = function( fn ) {
      return 'function' === typeof fn || '[object Function]' === toStr.call( fn );
    };
    var toInteger = function( value ) {
      var number = Number( value );
      if ( isNaN( number ) ) {
        return 0;
      }
      if ( 0 === number || ! isFinite( number ) ) {
        return number;
      }
      return ( 0 < number ? 1 : -1 ) * Math.floor( Math.abs( number ) );
    };
    var maxSafeInteger = Math.pow( 2, 53 ) - 1;
    var toLength = function( value ) {
      var len = toInteger( value );
      return Math.min( Math.max( len, 0 ), maxSafeInteger );
    };

    // The length property of the from method is 1.
    return function from( arrayLike/*, mapFn, thisArg */ ) {
      // 1. Let C be the this value.
      var C = this;

      // 2. Let items be ToObject(arrayLike).
      var items = Object( arrayLike );

      // 3. ReturnIfAbrupt(items).
      if ( null == arrayLike ) {
        throw new TypeError( 'Array.from requires an array-like object - not null or undefined' );
      }

      // 4. If mapfn is undefined, then let mapping be false.
      var mapFn = 1 < arguments.length ? arguments[1] : void undefined;
      var T;
      if ( 'undefined' !== typeof mapFn ) {

        // 5. else
        // 5. a If IsCallable(mapfn) is false, throw a TypeError exception.
        if ( ! isCallable( mapFn ) ) {
          throw new TypeError( 'Array.from: when provided, the second argument must be a function' );
        }

        // 5. b. If thisArg was supplied, let T be thisArg; else let T be undefined.
        if ( 2 < arguments.length ) {
          T = arguments[2];
        }
      }

      // 10. Let lenValue be Get(items, "length").
      // 11. Let len be ToLength(lenValue).
      var len = toLength( items.length );

      // 13. If IsConstructor(C) is true, then
      // 13. a. Let A be the result of calling the [[Construct]] internal method
      // of C with an argument list containing the single item len.
      // 14. a. Else, Let A be ArrayCreate(len).
      var A = isCallable( C ) ? Object( new C( len ) ) : new Array( len );

      // 16. Let k be 0.
      var k = 0;

      // 17. Repeat, while k < lenâ€¦ (also steps a - h)
      var kValue;
      while ( k < len ) {
        kValue = items[k];
        if ( mapFn ) {
          A[k] = 'undefined' === typeof T ? mapFn( kValue, k ) : mapFn.call( T, kValue, k );
        } else {
          A[k] = kValue;
        }
        k += 1;
      }

      // 18. Let putStatus be Put(A, "length", len, true).
      A.length = len;

      // 20. Return A.
      return A;
    };
  }() );
}

( function( panel, header ) {

  // Kill the script if there is no main menu item
  if ( ! panel ) {
    return;
  }

  // Get the height of our panel
  function getPanelHeight( panel ) {
    return panel.scrollHeight;
  }

  // Get our panel in place
  function positionPanel( panel, header ) {
    const offset = getPanelHeight( panel ) + getPanelHeight( header ) + 200;
    panel.style.transform = 'translateY(-' + offset + 'px)';
  }

  // Set panel initial position
  positionPanel( panel, header );

  /***** TOGGLE MAIN MENU ******/
  const mobileToggle = document.querySelector( '.menu-toggle' );
  mobileToggle.addEventListener( 'click', function() {
    if ( this.classList.contains( 'active' ) ) {
      this.firstElementChild.textContent = 'Menu';
      this.setAttribute( 'aria-expanded', 'false' );
      panel.classList.remove( 'open' );
      setTimeout( () => {
        positionPanel( panel, header );
        panel.classList.remove( 'active' );
      }, 275 );
    } else {
      this.firstElementChild.textContent = 'Close';
      this.setAttribute( 'aria-expanded', 'true' );
      panel.classList.add( 'active' );
      setTimeout( () => {
        positionPanel( panel, header );
        panel.classList.add( 'open' );
      }, 50 );
    }

    this.classList.toggle( 'active' );
  });

  /***** TOGGLE SUBMENUS ******/
  const arrows = [ ...document.querySelectorAll( '.arrow' ) ];
  arrows.forEach( element => {
    element.addEventListener( 'click', toggleSubMenu );
  });

  function toggleSubMenu() {
    if ( 0 == this.nextElementSibling.style.maxHeight ) {
      this.nextElementSibling.classList.add( 'open' );
      setTimeout( () => {
        this.nextElementSibling.style.maxHeight = this.nextElementSibling.scrollHeight + 'px';
      }, 100 );
    } else {
      this.nextElementSibling.style.maxHeight = this.nextElementSibling.style.maxHeight = null;
      setTimeout( () => {
        this.nextElementSibling.classList.remove( 'open' );
      }, 275 );
    }
    this.classList.toggle( 'active' );
  }

  /***** A11Y ******/
  const lis = [ ...document.querySelectorAll( '#site-navigation li' ) ];
  const anchors = [ ...document.querySelectorAll( '#site-navigation a' ) ];

  // Function that returns an array of an elements parents (up to the #site-navigation node)
  const getParents = function( elem ) {
    const parents = [];
    for ( ; elem; elem = elem.parentNode ) {
      if ( 'site-navigation' === elem.id ) {
        break;
      }
      parents.unshift( elem );
    }
    return parents;
  };

  anchors.forEach( anchor => {
    anchor.addEventListener( 'focus', () => {
      const parents = getParents( anchor );

      lis.forEach( li => {
        li.classList.remove( 'focus' );
      });

      // If a one level dropdown, add a focus class to the li
      if ( parents[parents.length - 2].classList.contains( 'menu-item-has-children' ) ) {
        anchor.parentElement.classList.add( 'focus' );
      }

      // If a more than a one level dropdown, add a focus class each li in the "parents" array
      if ( parents[parents.length - 3].classList.contains( 'sub-menu' ) ) {
        parents.forEach( parent => {
          if ( 'li' === parent.localName ) {
            parent.classList.add( 'focus' );
          }
        });
      }
    });

    // Reset all li's when focus is removed
    anchor.addEventListener( 'focusout', () => {
      lis.forEach( li => {
        li.classList.remove( 'focus' );
      });
    });
  });

  window.addEventListener( 'resize', function() {
    positionPanel( panel, header );
  });

}( document.getElementById( 'site-navigation' ), document.getElementById( 'masthead' ) ) );
