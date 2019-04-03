/* globals travelGlobals */
/* eslint-disable space-in-parens */

/**
 * Internal block libraries.
 */
const { registerBlockType } = wp.blocks;
const { PanelBody, Placeholder, ServerSideRender, TextControl } = wp.components;
const { InspectorControls } = wp.editor;
const { Fragment } = wp.element;
const { __ } = wp.i18n;

const blockName = 'amp-travel/featured';
/**
 * Register block.
 */
export default registerBlockType(
	blockName,
	{
		title: __( 'Featured Destinations' ),
		category: 'common',
		icon: 'location-alt',
		keywords: [
			__( 'Featured destinations', 'travel' ),
			__( 'Adventures', 'travel' ),
			__( 'Travel', 'travel' )
		],

		edit( { attributes, isSelected, setAttributes } ) {
			const { heading } = attributes;
			const ssrAttributes = Object.assign( {}, attributes, { context: 'server-side-render' } );

			return [
				isSelected && (
					<InspectorControls key='inspector'>
						<PanelBody title={ __( 'Featured Destinations settings', 'travel' ) }>
							<TextControl
								label={ __('Featured Destinations Header', 'travel' ) }
								value={ heading }
								onChange={ ( value ) => setAttributes( { heading: value } ) }
							/>
						</PanelBody>
					</InspectorControls>
				),
				<Fragment key="discover-ssr">
					<ServerSideRender
						block={ blockName }
						attributes={ ssrAttributes }
					/>
				</Fragment>
			];
		},

		save() {

			// Render in PHP.
			return null;
		}
	}
);
