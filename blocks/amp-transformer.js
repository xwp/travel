
const elementMapping = {
	'amp-img': 'img'
};

/**
 * De-AMP a React component.
 *
 * @param {wp.element.Component|string} element Element or string.
 * @return {wp.element.Component|string} Transformed element or string.
 */
export function deamplifiy( element ) {
	if ( 'string' === typeof element ) {
		return element;
	}
	const htmlElement = elementMapping[ element.type ];
	if ( htmlElement ) {
		return wp.element.createElement( elementMapping[ element.type ], element.props, wp.element.Children.map( element.props.children, deamplifiy ) );
	} else {
		return wp.element.cloneElement( element, element.props, wp.element.Children.map( element.props.children, deamplifiy ) );
	}
}
