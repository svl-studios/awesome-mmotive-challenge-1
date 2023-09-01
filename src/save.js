import { useBlockProps } from '@wordpress/block-editor';
import moment from 'moment/moment';

export default function save( { attributes: { table, colOne, colTwo, colThree, colFour, colFive } } ) {
	const blockProps = useBlockProps.save( { className:'kev-awesome-motive' } );

	if ( undefined !== table){
		const tbody = Object.values( table.data.rows );
		const colOneHide = colOne ? 'col-one-hide ' : '' ;
		const colTwoHide = colTwo ? 'col-two-hide ' : '' ;
		const colThreeHide = colThree ? 'col-three-hide ' : '' ;
		const colFourHide = colFour ? 'col-four-hide ' : '' ;
		const colFiveHide = colFive ? 'col-five-hide ' : '' ;

		return (
			<div { ...blockProps }>
				<h2 className={"kev-heading"}>{table.title}</h2>
				<table className={ colOneHide + colTwoHide + colThreeHide + colFourHide + colFiveHide + 'wp-list-table widefat striped'}>
					<thead>
					<tr key={table.title}>
						{ table.data.headers.map( item => (
							<td key={item}>
								{ item }
							</td>
						) ) }
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
		);
	}
}
