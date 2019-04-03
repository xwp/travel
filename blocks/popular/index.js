/* globals travelGlobals */
/* eslint-disable space-in-parens */

/**
 * Internal block libraries.
 */
const { registerBlockType } = wp.blocks;
const { PanelBody, ServerSideRender, TextControl } = wp.components;
const { InspectorControls } = wp.editor;
const { Fragment } = wp.element;
const { __ } = wp.i18n;

const blockName = 'amp-travel/popular';

/**
 * Register block.
 */
export default registerBlockType(
	blockName,
	{
		title: __( 'Popular Adventures' ),
		category: 'common',
		icon: 'universal-access',
		keywords: [
			__( 'Top rated', 'travel' ),
			__( 'Best', 'travel' ),
			__( 'Travel', 'travel' )
		],

		edit( { attributes, isSelected, setAttributes } ) {
			const { heading } = attributes;
			const ssrAttributes = Object.assign( {}, attributes, { context: 'server-side-render' } );

			return [
				isSelected && (
					<InspectorControls key="popular-inspector">
						<PanelBody title={ __( 'Popular block settings', 'travel' ) }>
							<TextControl
								label={ __( 'Popular Adventures Header', 'travel' ) }
								value={ heading }
								onChange={ ( value ) => setAttributes( { heading: value } ) }
							/>
						</PanelBody>
					</InspectorControls>
				),
				<Fragment key="popular-ssr">
					<ServerSideRender
						block={blockName}
						attributes={ssrAttributes}
					/>
				</Fragment>
			];
		},

		save() {

			// Handled by PHP.
			return null;
		}
	}
);
