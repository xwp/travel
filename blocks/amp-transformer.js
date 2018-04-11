
const elementMapping = {
	'amp-img': 'img'
};
const propsMapping = {
	'class': 'className',
	'srcset': 'srcSet'
};
const propsToRemove = [
	'[value]',
	'[class]',
	'[disabled]'
];

/**
 * De-AMP a React component.
 *
 * @param {wp.element.Component|string} element Element or string.
 * @return {wp.element.Component|string} Transformed element or string.
 */
export function deamplify( element ) {
	if ( 'string' === typeof element ) {
		return element;
	}

	let filteredProps = {};

	// Filter attributes.
	_.each( element.props, ( v, prop ) => {
		if ( -1 === propsToRemove.indexOf( prop ) ) {

			// Eslint is giving "There should be no spaces inside this paren." error for the line.
			if ( propsMapping[ prop ] ) { // eslint-disable-line
				filteredProps[ propsMapping[ prop ] ] = v;
			} else {
				filteredProps[ prop ] = v;
			}
		}
	});

	const htmlElement = elementMapping[ element.type ];
	if ( htmlElement ) {
		return wp.element.createElement( elementMapping[ element.type ], filteredProps, wp.element.Children.map( element.props.children, deamplify ) );
	} else {
		return wp.element.createElement( element.type, filteredProps, wp.element.Children.map( element.props.children, deamplify ) );
	}
}
