/* globals travelGlobals */
/* eslint-disable space-in-parens */

/**
 * Internal block libraries.
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { PanelBody, ServerSideRender, TextControl } = wp.components;
const { InspectorControls } = wp.editor;
const { Fragment } = wp.element;

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
			__( 'Top rated' ),
			__( 'Best' ),
			__( 'Travel' )
		],

		edit( { attributes, isSelected, setAttributes } ) {
			const { heading } = attributes;

			return [
				isSelected && (
					<InspectorControls key='inspector'>
						<PanelBody title={ __( 'Popular block settings' ) }>
							<TextControl
								label={ __( 'Popular Adventures Header' ) }
								value={ heading }
								onChange={ ( value ) => setAttributes( { heading: value } ) }
							/>
						</PanelBody>
					</InspectorControls>
				),
				<Fragment key="popular-ssr">
					<ServerSideRender
						block={blockName}
						attributes={attributes}
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
