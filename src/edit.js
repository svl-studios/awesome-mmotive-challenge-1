import { __ } from '@wordpress/i18n';
import { PanelBody, ToggleControl, Notice } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import './editor.scss';
import apiFetch from '@wordpress/api-fetch';
import moment from 'moment';

export default function editTable( { attributes: { colOne, colTwo, colThree, colFour, colFive }, setAttributes } ) {
	const blockProps = useBlockProps( { className:'kev-awesome-motive' } );
	const [ table, setTable ]	= useState('' );

	useEffect( () => {
		apiFetch( { path: 'kev-awesome-motive/v1/table-data' } ).then(
			(result) => {
				if ( false !== result ) {
					setTable( result );
					setAttributes( { table: result } );
				}
			}
		);
	}, []);

	if ( '' !== table ) {
		const tbody = Object.values( table.data.rows );
		const colOneHide = colOne ? 'col-one-hide ' : '' ;
		const colTwoHide = colTwo ? 'col-two-hide ' : '' ;
		const colThreeHide = colThree ? 'col-three-hide ' : '' ;
		const colFourHide = colFour ? 'col-four-hide ' : '' ;
		const colFiveHide = colFive ? 'col-five-hide ' : '' ;

		return (
			<>
				<InspectorControls>
					<PanelBody>
						<ToggleControl
							__nextHasNoMarginBottom
							label={__(
								'Hide the first column.', 'kev-awesome-motive'
							)}
							checked={!!colOne}
							onChange={ () => setAttributes( { colOne: ! colOne } ) }
						/>
						<ToggleControl
							__nextHasNoMarginBottom
							label={__(
								'Hide the second column.', 'kev-awesome-motive'
							)}
							checked={!!colTwo}
							onChange={ () => setAttributes( { colTwo: ! colTwo } )}
						/>
						<ToggleControl
							__nextHasNoMarginBottom
							label={__(
								'Hide the third column.', 'kev-awesome-motive'
							)}
							checked={!!colThree}
							onChange={ () => setAttributes( { colThree: ! colThree } )}
						/>
						<ToggleControl
							__nextHasNoMarginBottom
							label={__(
								'Hide the fourth column.', 'kev-awesome-motive'
							)}
							checked={!!colFour}
							onChange={ () => setAttributes( { colFour: ! colFour} )}
						/>
						<ToggleControl
							__nextHasNoMarginBottom
							label={__(
								'Hide the fifth column.', 'kev-awesome-motive'
							)}
							checked={!!colFive}
							onChange={ () => setAttributes( { colFive: ! colFive } )}
						/>
					</PanelBody>
				</InspectorControls>
				<div {...blockProps}>
					<h2 className={"kev-heading"}>{table.title}</h2>
					<table className={ colOneHide + colTwoHide + colThreeHide + colFourHide + colFiveHide + 'wp-list-table widefat striped' }>
						<thead>
							<tr key={table.title}>
								{ table.data.headers.map( ( item ) =>
									<td key={item}>
										{ item }
									</td>
								) }
							</tr>
						</thead>
						<tbody>
						{ tbody.map( ( item, i ) =>
							<tr key={i}>
								<td>
									{ tbody[i].id }
								</td>
								<td>
									{ tbody[i].fname }
								</td>
								<td>
									{ tbody[i].lname }
								</td>
								<td>
									{ tbody[i].email }
								</td>
								<td>
									{ moment( tbody[i].date * 1000 ).format('L') }
								</td>
							</tr>
						)}
						</tbody>
						<tfoot>
							<tr key={table.title}>
								{ table.data.headers.map( item => (
									<td key={item}>
										{ item }
									</td>
								) ) }
							</tr>
						</tfoot>
					</table>
				</div>
			</>
		);
	} else if (false === table) {
		return( <Notice isDismissible={ false } status="error">{__( "Kev's Awesome Table could not connect to the data server. Please check your internet connection.", 'kev-awesome-motive' ) }</Notice> );
	}
}
