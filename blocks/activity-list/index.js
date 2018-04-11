// jscs:disable disallowMultipleLineStrings
// jscs:disable validateQuoteMarks

/**
 * Internal block libraries.
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

const renderStaticActivityList = () => {
	return (
		<section className='travel-activities pb4 pt3 relative'>
			<div className='max-width-3 mx-auto px1 md-px2'>
				<h3 className='bold h1 line-height-2 mb2 md-hide lg-hide' aria-hidden='true'>Browse<br />by activity</h3>
				<h3 className='bold h1 line-height-2 mb2 xs-hide sm-hide center'>Browse by activity</h3>
			</div>
			<div className='overflow-scroll'>
				<div className='travel-overflow-container'>
					<div className='flex justify-center p1 md-px1 mxn1'>
						<a href='travel-results.amp' className='travel-activities-activity travel-type-active mx1' on="
							tap:AMP.setState({
								ui_viewIndex: 1,
								fields_type: ['active'],
								query_type: ['active']
							})
							">
							<div className='travel-shadow circle inline-block'>
								<div className='travel-activities-activity-icon'>

									<svg className='travel-icon' viewBox='0 0 70 100'><path fill='currentColor' d='M63.157 50.527h-11.03a9.028 9.028 0 0 1-7.13-3.537c-.78-.97-1.497-1.99-2.14-3.058a.325.325 0 0 0-.297-.123.324.324 0 0 0-.256.196L37.398 55.4a.344.344 0 0 0 .073.38L48.65 66.79a10.925 10.925 0 0 1 3.215 7.238l1.118 17.65c.045 2.225-1.624 4.105-3.82 4.303-2.196.198-4.17-1.352-4.517-3.548l-2.053-16.08a1.358 1.358 0 0 0-.492-.886L31.105 66.64a.317.317 0 0 0-.277-.06.317.317 0 0 0-.218.182l-4.26 9.28a21.584 21.584 0 0 1-3.75 5.635c-1.53 1.66-8.837 10.284-9.574 11.084a4.128 4.128 0 0 1-3.182 1.253c-2.147-.025-3.868-1.8-3.844-3.967 0-.914.3-1.802.858-2.523.555-.716 9.03-12.36 9.247-12.638.216-.282.357-.614.408-.966l1.597-11.13a44.158 44.158 0 0 1 3.7-12.416l6.11-13.06a.344.344 0 0 0-.026-.337.33.33 0 0 0-.303-.144c-.253.027-11.375.68-11.817.728a.981.981 0 0 0-.855.857l-1.526 11.547c-.17 1.49-1.472 2.584-2.957 2.48-1.484-.104-2.625-1.368-2.588-2.87v-12.31c-.028-3.69 2.44-6.928 5.982-7.848 3.51-.88 13.463-2.706 14.595-2.99 3.37-.843 6.93-.426 10.02 1.173l4.477 2.31a10.575 10.575 0 0 1 4.428 4.35c1.022 1.876 3.81 7.288 4 7.638.188.347.52.59.905.664l11.41 2.14a2.94 2.94 0 0 1 2.324 3.142c-.132 1.49-1.35 2.646-2.834 2.682zM43.49 24A9.5 9.5 0 0 1 34 14.492c.004-5.245 4.26-9.494 9.504-9.492a9.5 9.5 0 1 1-.014 19z'></path></svg>
								</div>
							</div>
							<p className='bold center line-height-4'>
								Active
							</p>
						</a>
						<a href='travel-results.amp' className='travel-activities-activity travel-type-artistic mx1' on="
							tap:AMP.setState({
								ui_viewIndex: 1,
								fields_type: ['artistic'],
								query_type: ['artistic']
							})
						">
							<div className='travel-shadow circle inline-block'>
								<div className='travel-activities-activity-icon'>

									<svg className='travel-icon' viewBox='0 0 100 100'><path fill='currentColor' d='M91 9c2.01.413 3.58 1.957 4 3.933 0 3.28-29.278 38.624-37 46.217C52.995 64.072 46.184 68 42.5 68c-1.634 0-7.5-5.896-7.5-7.375 0-3.623 3.995-10.32 9-15.242C51.722 37.79 87.665 9 91 9zM5 86c0-1.75 2.114-.465 5.345-3.686 2.71-2.702 1.692-9.02 7.354-14.665 4.87-4.864 12.77-4.867 17.643-.007 4.874 4.86 4.876 12.74.006 17.605a22.75 22.75 0 0 1-16.32 6.752C11.857 92 5 87.75 5 86z'></path></svg>
								</div>
							</div>
							<p className='bold center line-height-4'>
								Artistic
							</p>
						</a>
						<a href='travel-results.amp' className='travel-activities-activity travel-type-drinks mx1' on="
						tap:AMP.setState({
							ui_viewIndex: 1,
							fields_type: ['drinks'],
							query_type: ['drinks']
						})
						">
							<div className='travel-shadow circle inline-block'>
								<div className='travel-activities-activity-icon'>

									<svg className='travel-icon' viewBox='0 0 86 100'><path fill='currentColor' d='M81.637 15.817L48.46 58.92a6.995 6.995 0 0 0-1.454 4.27v17.15c-.004.843.6 1.568 1.43 1.72 5.734 1.04 14.485 2.664 14.665 2.7.816.175 1.39.907 1.363 1.74v1.75a1.75 1.75 0 0 1-1.75 1.75H24.286a1.75 1.75 0 0 1-1.75-1.75V86.5a1.723 1.723 0 0 1 1.36-1.74c.18-.036 8.933-1.66 14.666-2.7a1.743 1.743 0 0 0 1.43-1.72V63.187a6.99 6.99 0 0 0-1.453-4.268L5.363 15.817A1.75 1.75 0 0 1 6.75 13h73.5a1.751 1.751 0 0 1 1.387 2.817zM48 43c2.76 0 5-2.24 5-5s-2.24-5-5-5a5.002 5.002 0 0 0-3.536 8.535A5.001 5.001 0 0 0 48 43zm20.565-23h-50.13a.435.435 0 0 0-.39.244.44.44 0 0 0 .045.46l4.428 5.784c.247.323.63.512 1.035.512h39.894c.405 0 .788-.19 1.035-.512l4.428-5.784c.1-.132.118-.31.045-.46a.433.433 0 0 0-.39-.244z'></path></svg>
								</div>
							</div>
							<p className='bold center line-height-4'>
								Drinks
							</p>
						</a>
						<a href='travel-results.amp' className='travel-activities-activity travel-type-fashion mx1' on="
						tap:AMP.setState({
							ui_viewIndex: 1,
							fields_type: ['fashion'],
							query_type: ['fashion']
						})
						">
							<div className='travel-shadow circle inline-block'>
								<div className='travel-activities-activity-icon'>

									<svg className='travel-icon' viewBox='0 0 100 100'><path fill='currentColor' d='M94.93 77.903l-9.12 3.887a1.767 1.767 0 0 1-2.381-1.102L71.505 41.745s3.367 47.975 3.497 49.94a3.511 3.511 0 0 1-3.372 3.732l-13.967.578a3.522 3.522 0 0 1-3.672-3.415c-.048-1.958-1.686-62.796-1.686-62.796a27.9 27.9 0 0 1 .833-7.503l2.597-9.236a.875.875 0 0 0-.855-1.088h-8.76a.88.88 0 0 0-.855 1.09l2.597 9.24a27.87 27.87 0 0 1 .833 7.5s-1.638 60.84-1.687 62.798a3.515 3.515 0 0 1-3.672 3.413L29.37 95.42a3.513 3.513 0 0 1-3.373-3.733c.13-1.965 3.498-49.94 3.498-49.94L17.573 80.688a1.768 1.768 0 0 1-2.382 1.1L6.07 77.904a1.75 1.75 0 0 1-1.006-2.072c.23-.844 12.75-46.918 13.806-50.765a14.047 14.047 0 0 1 7.294-8.85 113.943 113.943 0 0 0 10.233-5.09 21.138 21.138 0 0 0 3.178-3.683A7.067 7.067 0 0 1 44.925 5h11.15a7.067 7.067 0 0 1 5.352 2.444 21.1 21.1 0 0 0 3.18 3.682 114.173 114.173 0 0 0 10.23 5.092 14.037 14.037 0 0 1 7.295 8.85c1.056 3.846 13.575 49.92 13.807 50.764a1.75 1.75 0 0 1-1.01 2.07z'></path></svg>
								</div>
							</div>
							<p className='bold center line-height-4'>
								Fashion
							</p>
						</a>
						<a href='travel-results.amp' className='travel-activities-activity travel-type-food mx1' on="
						tap:AMP.setState({
							ui_viewIndex: 1,
							fields_type: ['food'],
							query_type: ['food']
						})
						">
							<div className='travel-shadow circle inline-block'>
								<div className='travel-activities-activity-icon'>
									<svg className='travel-icon' viewBox='0 0 72 100'><path fill='currentColor' d='M61.4 94h-3.6c-1.988 0-3.6-1.64-3.6-3.666v-31.14a3.612 3.612 0 0 0-1.214-2.74C50.934 54.666 47 49.83 47 38.998c0-21.942 8.905-33.096 16.295-33 .962.04 1.718.853 1.705 1.833v82.5a3.7 3.7 0 0 1-1.055 2.593A3.558 3.558 0 0 1 61.4 94zM24.57 57.725v32.608c0 2.025-1.662 3.667-3.713 3.667h-3.714c-2.05 0-3.714-1.642-3.714-3.667V57.725C13.43 49.117 6 50.713 6 39c0-9.686 1.453-28.055 1.79-32.17A.912.912 0 0 1 8.713 6h1.95c.505 0 .917.398.93.895 0 0 .607 25.564.63 26.59a1.904 1.904 0 0 0 1.9 1.85 1.903 1.903 0 0 0 1.93-1.82l1.054-26.634c.02-.49.43-.88.93-.88h1.927c.5 0 .91.39.93.88 0 0 1.013 25.62 1.052 26.636a1.906 1.906 0 0 0 1.93 1.82 1.904 1.904 0 0 0 1.9-1.85l.632-26.59a.924.924 0 0 1 .93-.896h1.95a.913.913 0 0 1 .923.832C30.548 10.945 32 29.314 32 39c0 11.715-7.43 10.105-7.43 18.725z'></path></svg>
								</div>
							</div>
							<p className='bold center line-height-4'>
								Food
							</p>
						</a>
						<a href='travel-results.amp' className='travel-activities-activity travel-type-music mx1' on="
						tap:AMP.setState({
							ui_viewIndex: 1,
							fields_type: ['music'],
							query_type: ['music']
						})
						">
							<div className='travel-shadow circle inline-block'>
								<div className='travel-activities-activity-icon'>

									<svg className='travel-icon' viewBox='0 0 100 100'><path fill='currentColor' d='M83.563 24.417c-1.02 0-2 .406-2.723 1.128L63.3 43.09a1.608 1.608 0 0 0-.117 2.118c5.59 7.328 5.782 13.566 1.213 18.132-4.354 4.35-6.927 4.78-9.513 7.366-2.587 2.586-.266 9.583-7.574 16.887s-18.113 8.39-30.704-4.194C4.016 70.813 5.102 60.015 12.41 52.71c7.308-7.304 14.36-4.933 16.946-7.52 2.585-2.584 2.965-5.206 7.32-9.557 4.564-4.563 10.8-4.377 18.123 1.198.634.496 1.54.446 2.114-.12l17.546-17.55a3.849 3.849 0 0 0 1.128-2.723c0-1.02.405-2 1.128-2.723L82.96 7.47c.396-.398.97-.558 1.513-.423a11.872 11.872 0 0 1 5.47 3.012 11.867 11.867 0 0 1 3.01 5.47 1.591 1.591 0 0 1-.422 1.512l-6.245 6.248a3.855 3.855 0 0 1-2.722 1.127zm-59.25 39.996l-.906.906a1.406 1.406 0 0 0-.123 1.837c1.576 2.132 1.986 4.675 3.435 6.124 1.448 1.45 3.992 1.86 6.123 3.436.558.42 1.342.37 1.838-.123l.907-.906a1.41 1.41 0 0 0 0-1.993l-9.28-9.28a1.408 1.408 0 0 0-1.993-.001zM45.504 48a6.5 6.5 0 1 0-9.193 9.192 6.5 6.5 0 0 0 13.786-7.288A6.488 6.488 0 0 0 45.502 48z'></path></svg>
								</div>
							</div>
							<p className='bold center line-height-4'>
								Music
							</p>
						</a>
						<a href='travel-results.amp' className='travel-activities-activity travel-type-nature mx1' on="
						tap:AMP.setState({
							ui_viewIndex: 1,
							fields_type: ['nature'],
							query_type: ['nature']
						})
						">
							<div className='travel-shadow circle inline-block'>
								<div className='travel-activities-activity-icon'>

									<svg className='travel-icon' viewBox='0 0 76 100'><path fill='currentColor' d='M71.57 71a16.245 16.245 0 0 1-12.498 5.385 38.102 38.102 0 0 1-9.7-1.494A23.872 23.872 0 0 1 38 78a23.847 23.847 0 0 1-11.37-3.11 38.088 38.088 0 0 1-9.702 1.495A16.25 16.25 0 0 1 4.428 71a1.625 1.625 0 0 1 .145-2.337 68.925 68.925 0 0 0 14.152-16.12c-1.54-.54-3-1.283-4.338-2.213a1.612 1.612 0 0 1-.71-1.186c-.045-.482.13-.958.476-1.297a86.822 86.822 0 0 0 13.264-17.103 18.438 18.438 0 0 1-3.132-1.24 1.616 1.616 0 0 1-.88-1.183 1.61 1.61 0 0 1 .455-1.4A51.206 51.206 0 0 0 36.49 7.984C36.752 7.386 37.344 7 38 7s1.248.386 1.51.983A51.206 51.206 0 0 0 52.14 26.92a1.604 1.604 0 0 1-.426 2.583c-1.002.51-2.05.924-3.13 1.24a86.87 86.87 0 0 0 13.263 17.104c.346.34.52.815.476 1.297a1.61 1.61 0 0 1-.71 1.186 18.16 18.16 0 0 1-4.338 2.214 68.96 68.96 0 0 0 14.15 16.12c.34.285.545.696.572 1.137.027.442-.127.875-.426 1.2zm-40.75 9.75a.825.825 0 0 1 .328-.594.758.758 0 0 1 .645-.13c3.75.988 7.675.987 11.424-.003.223-.056.458-.01.645.13s.307.356.33.594A40.69 40.69 0 0 0 46.92 92.3c.146.396.09.84-.15 1.184a1.177 1.177 0 0 1-1.032.514H29.264a1.179 1.179 0 0 1-1.035-.514 1.292 1.292 0 0 1-.15-1.184 40.73 40.73 0 0 0 2.74-11.55z'></path></svg>
								</div>
							</div>
							<p className='bold center line-height-4'>
								Nature
							</p>
						</a>
						<a href='travel-results.amp' className='travel-activities-activity travel-type-nightlife mx1' on="
						tap:AMP.setState({
							ui_viewIndex: 1,
							fields_type: ['nightlife'],
							query_type: ['nightlife']
						})
						">
							<div className='travel-shadow circle inline-block'>
								<div className='travel-activities-activity-icon'>

									<svg className='travel-icon' viewBox='0 0 100 100'><path fill='currentColor' d='M35.272 26.553a38.191 38.191 0 0 0 38.181 38.194 37.46 37.46 0 0 0 10.343-1.673 3.304 3.304 0 0 1 3.88 4.604c-7.722 16.818-25.603 26.543-43.923 23.888-18.32-2.655-32.702-17.054-35.33-35.372-2.625-18.318 7.13-36.177 23.968-43.87a3.306 3.306 0 1 1 4.612 3.883 37.474 37.474 0 0 0-1.73 10.346z'></path></svg>
								</div>
							</div>
							<p className='bold center line-height-4'>
								Nightlife
							</p>
						</a>
						<a href='travel-results.amp' className='travel-activities-activity travel-type-tours mx1' on="
						tap:AMP.setState({
							ui_viewIndex: 1,
							fields_type: ['tours'],
							query_type: ['tours']
						})
						">
							<div className='travel-shadow circle inline-block'>
								<div className='travel-activities-activity-icon'>

									<svg className='travel-icon' viewBox='0 0 100 100'><path fill='currentColor' d='M89.35 47.336h-2.49l.303 3.358c.24 2.65.36 5.304.36 7.966v18.007c0 4.05-3.27 7.333-7.305 7.333H21.783c-4.035 0-7.305-3.283-7.305-7.333V58.66c0-2.66.12-5.315.36-7.966l.304-3.358h-2.49A3.658 3.658 0 0 1 9 43.67v-11a3.659 3.659 0 0 1 3.652-3.665h4.15l.97-10.72a7.327 7.327 0 0 1 4.274-6.024A77.014 77.014 0 0 1 51 7.007a77.011 77.011 0 0 1 28.954 5.255 7.327 7.327 0 0 1 4.273 6.026l.97 10.72h4.15A3.658 3.658 0 0 1 93 32.673v11a3.659 3.659 0 0 1-3.65 3.666zM74.5 72c3.038 0 5.5-2.24 5.5-5s-2.462-5-5.5-5-5.5 2.24-5.5 5 2.462 5 5.5 5zM27 72c2.76 0 5-2.24 5-5s-2.24-5-5-5a5.002 5.002 0 0 0-3.535 8.536A5.002 5.002 0 0 0 27 72zm34.375-60h-21.75C37.623 12 36 13.567 36 15.5s1.623 3.5 3.625 3.5h21.75C63.377 19 65 17.433 65 15.5S63.377 12 61.375 12zm19.61 38.726l-2.095-22.43c-.186-1.877-1.795-3.306-3.713-3.296H27.82c-1.917-.01-3.526 1.42-3.712 3.297l-2.097 22.43c-.072.844.22 1.68.805 2.304.585.624 1.41.976 2.273.97h52.856a3.064 3.064 0 0 0 2.25-.96c.58-.616.867-1.444.795-2.28l-.004-.034zM19.876 87h11.25C32.16 87 33 87.784 33 88.75v1.75c0 1.933-1.68 3.5-3.75 3.5h-7.5C19.68 94 18 92.433 18 90.5v-1.75c0-.464.198-.91.55-1.237.35-.33.828-.513 1.325-.513zm51 0h11.25C83.16 87 84 87.784 84 88.75v1.75c0 1.933-1.68 3.5-3.75 3.5h-7.5C70.68 94 69 92.433 69 90.5v-1.75c0-.464.198-.91.55-1.237.35-.33.828-.513 1.325-.513z'></path></svg>
								</div>
							</div>
							<p className='bold center line-height-4'>
								Tours
							</p>
						</a>
						<a href='travel-results.amp' className='travel-activities-activity travel-type-water mx1' on="
						tap:AMP.setState({
							ui_viewIndex: 1,
							fields_type: ['water'],
							query_type: ['water']
						})
						">
							<div className='travel-shadow circle inline-block'>
								<div className='travel-activities-activity-icon'>

									<svg className='travel-icon' viewBox='0 0 100 100'><path fill='currentColor' d='M91.573 93.997a15.786 15.786 0 0 1-8.377-2.22 10.496 10.496 0 0 0-10.63 0c-5.24 2.96-11.51 2.96-16.752 0a9.428 9.428 0 0 0-5.314-1.446 9.422 9.422 0 0 0-5.315 1.448 15.789 15.789 0 0 1-8.376 2.22 15.796 15.796 0 0 1-8.378-2.22 9.42 9.42 0 0 0-5.314-1.447 9.422 9.422 0 0 0-5.315 1.448A15.789 15.789 0 0 1 9.426 94C7.535 93.997 6 92.355 6 90.33s1.535-3.665 3.427-3.665a9.424 9.424 0 0 0 5.314-1.445A15.8 15.8 0 0 1 23.119 83c2.926-.06 5.815.705 8.376 2.22a9.412 9.412 0 0 0 5.315 1.445 9.429 9.429 0 0 0 5.314-1.445A15.789 15.789 0 0 1 50.5 83c2.926-.06 5.815.705 8.376 2.22a10.496 10.496 0 0 0 10.63 0c5.24-2.958 11.51-2.958 16.75 0a9.428 9.428 0 0 0 5.317 1.445c1.892 0 3.427 1.64 3.427 3.665 0 2.024-1.535 3.665-3.427 3.665zM90.293 62h-30.89a1.406 1.406 0 0 1-1.291-1.961 48.605 48.605 0 0 0 3.262-18.51 49.415 49.415 0 0 0-3.264-18.62 1.37 1.37 0 0 1 .33-1.54c.277-.26.65-.39 1.03-.364 17.262 1.17 31.527 22.68 32.527 39.178a1.711 1.711 0 0 1-1.705 1.82zm-1.746 4a2.458 2.458 0 0 1 1.809 4.118 58.618 58.618 0 0 1-9.736 8.3 6.82 6.82 0 0 1-3.724 1.185 19.938 19.938 0 0 0-9.278 2.41 7.646 7.646 0 0 1-7.502-.004 19.895 19.895 0 0 0-9.81-2.414 19.927 19.927 0 0 0-9.82 2.417 6.575 6.575 0 0 1-3.746.98 6.594 6.594 0 0 1-3.754-.984 19.909 19.909 0 0 0-9.812-2.415c-2.76-.05-5.5.49-8.036 1.578A1.525 1.525 0 0 1 13 79.778V68.55A2.547 2.547 0 0 1 15.545 66h73.002zm-37.12-4H7.715a1.717 1.717 0 0 1-1.295-2.844L50.99 7.593A1.713 1.713 0 0 1 54 8.718v50.703c0 .685-.272 1.34-.754 1.825a2.56 2.56 0 0 1-1.818.754z'></path></svg>
								</div>
							</div>
							<p className='bold center line-height-4'>
								Water
							</p>
						</a>

					</div>
				</div>
			</div>
		</section>
	);
};

/**
 * Register block.
 */
export default registerBlockType(
	'amp-travel/activity-list',
	{
		title: __( 'Activity list' ),
		category: 'common',
		icon: 'wordpress-alt',
		keywords: [
			__( 'Browse activities' ),
			__( 'Travel' )
		],

		edit() {
			return renderStaticActivityList();
		},
		save() {
			return renderStaticActivityList();
		}
	}
);
