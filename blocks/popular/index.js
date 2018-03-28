/* globals travel_globals */

/**
 * Internal block libraries.
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

/**
 * Register block.
 */
export default registerBlockType(
	'amp-travel/popular',
	{
		title: __( 'Popular Adventures block' ),
		category: 'common',
		icon: 'wordpress-alt',
		keywords: [
			__( 'High rating' ),
			__( 'Best' ),
			__( 'Top' ),
		],

		edit: props => {
			return (
				<section className="travel-popular pb4 pt3 relative">
					<header className="max-width-3 mx-auto px1 md-px2">
						<h3 className="h1 bold line-height-2 md-hide lg-hide">Top Adventures<br/>Near You</h3>
						<h3 className="h1 bold line-height-2 xs-hide sm-hide center">Top Adventures Near You</h3>
					</header>
					<div className="overflow-scroll">
						<div className="travel-overflow-container">
							<div className="flex px1 md-px2 mxn1">
								<div className="m1 mt3 mb2">
									<div className="travel-popular-tilt-right mb1">
										<div className="relative travel-results-result">
											<a className="travel-results-result-link block relative" href="#">
												<img width="346" height="200" src={ travel_globals.theme_url + "/img/surf-day.jpg" } />
											</a>
											<div className="travel-results-result-like absolute top-0 right-0">
												<div className="p1">

													<label className="travel-like">
														<input type="checkbox" className="absolute" />
															<div className="travel-like-hearts circle inline-block relative">
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart travel-like-heart-white absolute mx-auto "></div>
																<div className="travel-like-heart travel-like-heart-solid absolute mx-auto "></div>
																<div className="travel-like-heart travel-like-heart-outline absolute mx-auto "></div>
															</div>
													</label>
												</div>
											</div>
										</div>
									</div>

									<div className="h2 line-height-2 mb1">
										<span className="travel-results-result-text">Surf Day. Board and Wetsuits Included in Price!</span>
										<span className="travel-results-result-subtext h3">•</span>
										<span className="travel-results-result-subtext h3">$&nbsp;</span><span className="black bold">100</span>
									</div>

									<div className="h4 line-height-2">
										<div className="inline-block relative mr1 h3 line-height-2">
											<div className="travel-results-result-stars green">★★★★★</div>
										</div>
										<span className="travel-results-result-subtext mr1">241 Reviews</span>
										<span className="travel-results-result-subtext">
											<svg className="travel-icon" viewBox="0 0 77 100"><g fill="none" fill-rule="evenodd"><path stroke="currentColor" stroke-width="7.5" d="M38.794 93.248C58.264 67.825 68 49.692 68 38.848 68 22.365 54.57 9 38 9S8 22.364 8 38.85c0 10.842 9.735 28.975 29.206 54.398a1 1 0 0 0 1.588 0z"></path><circle cx="38" cy="39" r="10" fill="currentColor"></circle></g></svg>
											Oaxaca
										</span>
									</div>
								</div>
								<div className="m1 mt3 mb2">
									<div className="travel-results-result relative mb1">
										<div className="relative travel-results-result">
											<a className="travel-results-result-link block relative" href="#">
												<img width="346" height="200" src={ travel_globals.theme_url + "/img/discover-electronic-scene.jpg" } />
											</a>
											<div className="travel-results-result-flags absolute top-0 left-0">
												<div className="p1"><span className="travel-pill bold">NEW</span></div>
											</div>
											<div className="travel-results-result-like absolute top-0 right-0">
												<div className="p1">
													<label className="travel-like">
														<input type="checkbox" className="absolute" />
															<div className="travel-like-hearts circle inline-block relative">
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart travel-like-heart-white absolute mx-auto "></div>
																<div className="travel-like-heart travel-like-heart-solid absolute mx-auto "></div>
																<div className="travel-like-heart travel-like-heart-outline absolute mx-auto "></div>
															</div>
													</label>
												</div>
											</div>
										</div>
									</div>

									<div className="h2 line-height-2 mb1">
										<span className="travel-results-result-text">Discover Oaxaca's Electronic Music Scene with a Top DJ</span>
										<span className="travel-results-result-subtext h3">•</span>
										<span className="travel-results-result-subtext h3">$&nbsp;</span><span className="black bold">113</span>
									</div>

									<div className="h4 line-height-2">
										<div className="inline-block relative mr1 h3 line-height-2">
											<div className="travel-results-result-stars green">★★★★★</div>
										</div>
										<span className="travel-results-result-subtext mr1">42 Reviews</span>
										<span className="travel-results-result-subtext"><svg className="travel-icon" viewBox="0 0 77 100"><g fill="none" fill-rule="evenodd"><path stroke="currentColor" stroke-width="7.5" d="M38.794 93.248C58.264 67.825 68 49.692 68 38.848 68 22.365 54.57 9 38 9S8 22.364 8 38.85c0 10.842 9.735 28.975 29.206 54.398a1 1 0 0 0 1.588 0z"></path><circle cx="38" cy="39" r="10" fill="currentColor"></circle></g></svg> Oaxaca</span>
									</div>
								</div>
								<div className="m1 mt3 mb2">
									<div className="travel-popular-tilt-left mb1">
										<div className="relative travel-results-result">
											<a className="travel-results-result-link block relative" href="#">
												<img width="346" height="200" src={ travel_globals.theme_url + "/img/skateboard-around-city.jpg" } />
											</a>
											<div className="travel-results-result-like absolute top-0 right-0">
												<div className="p1">

													<label className="travel-like">
														<input type="checkbox" className="absolute" />
															<div className="travel-like-hearts circle inline-block relative">
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart travel-like-heart-white absolute mx-auto "></div>
																<div className="travel-like-heart travel-like-heart-solid absolute mx-auto "></div>
																<div className="travel-like-heart travel-like-heart-outline absolute mx-auto "></div>
															</div>
													</label>
												</div>
											</div>
										</div>
									</div>

									<div className="h2 line-height-2 mb1">
										<span className="travel-results-result-text">Skateboard Around the City</span>
										<span className="travel-results-result-subtext h3">•</span>
										<span className="travel-results-result-subtext h3">$&nbsp;</span><span className="black bold">92</span>
									</div>

									<div className="h4 line-height-2">
										<div className="inline-block relative mr1 h3 line-height-2">
											<div className="travel-results-result-stars green">★★★★★</div>
										</div>
										<span className="travel-results-result-subtext mr1">17 Reviews</span>
										<span className="travel-results-result-subtext"><svg className="travel-icon" viewBox="0 0 77 100"><g fill="none" fill-rule="evenodd"><path stroke="currentColor" stroke-width="7.5" d="M38.794 93.248C58.264 67.825 68 49.692 68 38.848 68 22.365 54.57 9 38 9S8 22.364 8 38.85c0 10.842 9.735 28.975 29.206 54.398a1 1 0 0 0 1.588 0z"></path><circle cx="38" cy="39" r="10" fill="currentColor"></circle></g></svg> Mexico City</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			);
		},
		save: props => {
			return (
				<section className="travel-popular pb4 pt3 relative">
					<header className="max-width-3 mx-auto px1 md-px2">
						<h3 className="h1 bold line-height-2 md-hide lg-hide" aria-hidden="true">Top Adventures<br/>Near You</h3>
						<h3 className="h1 bold line-height-2 xs-hide sm-hide center">Top Adventures Near You</h3>
					</header>
					<div className="overflow-scroll">
						<div className="travel-overflow-container">
							<div className="flex px1 md-px2 mxn1">
								<div className="m1 mt3 mb2">
									<div className="travel-popular-tilt-right mb1">
										<div className="relative travel-results-result">
											<a className="travel-results-result-link block relative" href="#">
												<amp-img class="block rounded" width="346" height="200" noloading="" src={ travel_globals.theme_url + "/img/surf-day.jpg" } srcset={ travel_globals.theme_url + "/img/surf-day@2x.jpg 2x, " + travel_globals.theme_url + "/img/surf-day.jpg 1x" }></amp-img>
											</a>
											<div className="travel-results-result-like absolute top-0 right-0">
												<div className="p1">
													<label className="travel-like">
														<input type="checkbox" className="absolute"/>
														<div className="travel-like-hearts circle inline-block relative">
															<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
															<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
															<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
															<div className="travel-like-heart travel-like-heart-white absolute mx-auto "></div>
															<div className="travel-like-heart travel-like-heart-solid absolute mx-auto "></div>
															<div className="travel-like-heart travel-like-heart-outline absolute mx-auto "></div>
														</div>
													</label>
												</div>
											</div>
										</div>
									</div>

									<div className="h2 line-height-2 mb1">
										<span className="travel-results-result-text">Surf Day. Board and Wetsuits Included in Price!</span>
										<span className="travel-results-result-subtext h3">•</span>
										<span className="travel-results-result-subtext h3">$&nbsp;</span><span className="black bold">100</span>
									</div>

									<div className="h4 line-height-2">
										<div className="inline-block relative mr1 h3 line-height-2">
											<div className="travel-results-result-stars green">★★★★★</div>
										</div>
										<span className="travel-results-result-subtext mr1">241 Reviews</span>
										<span className="travel-results-result-subtext"><svg className="travel-icon" viewBox="0 0 77 100"><g fill="none" fill-rule="evenodd"><path stroke="currentColor" stroke-width="7.5" d="M38.794 93.248C58.264 67.825 68 49.692 68 38.848 68 22.365 54.57 9 38 9S8 22.364 8 38.85c0 10.842 9.735 28.975 29.206 54.398a1 1 0 0 0 1.588 0z"></path><circle cx="38" cy="39" r="10" fill="currentColor"></circle></g></svg> Oaxaca</span>
									</div>
								</div>
								<div className="m1 mt3 mb2">
									<div className="travel-results-result relative mb1">
										<div className="relative travel-results-result">
											<a className="travel-results-result-link block relative" href="#">
												<amp-img class="block rounded" width="346" height="200" noloading="" src={ travel_globals.theme_url + "/imgdiscover-electronic-scene.jpg" } srcset={ travel_globals.theme_url + "/img/discover-electronic-scene@2x.jpg 2x, " + travel_globals.theme_url + "/img/discover-electronic-scene.jpg 1x" }></amp-img>
											</a>
											<div className="travel-results-result-flags absolute top-0 left-0">
												<div className="p1"><span className="travel-pill bold">NEW</span></div>
											</div>
											<div className="travel-results-result-like absolute top-0 right-0">
												<div className="p1">
													<label className="travel-like">
														<input type="checkbox" className="absolute"/>
															<div className="travel-like-hearts circle inline-block relative">
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart travel-like-heart-white absolute mx-auto "></div>
																<div className="travel-like-heart travel-like-heart-solid absolute mx-auto "></div>
																<div className="travel-like-heart travel-like-heart-outline absolute mx-auto "></div>
															</div>
													</label>
												</div>
											</div>
										</div>
									</div>

									<div className="h2 line-height-2 mb1">
										<span className="travel-results-result-text">Discover Oaxaca's Electronic Music Scene with a Top DJ</span>
										<span className="travel-results-result-subtext h3">•</span>
										<span className="travel-results-result-subtext h3">$&nbsp;</span><span className="black bold">113</span>
									</div>

									<div className="h4 line-height-2">
										<div className="inline-block relative mr1 h3 line-height-2">
											<div className="travel-results-result-stars green">★★★★★</div>
										</div>
										<span className="travel-results-result-subtext mr1">42 Reviews</span>
										<span className="travel-results-result-subtext"><svg className="travel-icon" viewBox="0 0 77 100"><g fill="none" fill-rule="evenodd"><path stroke="currentColor" stroke-width="7.5" d="M38.794 93.248C58.264 67.825 68 49.692 68 38.848 68 22.365 54.57 9 38 9S8 22.364 8 38.85c0 10.842 9.735 28.975 29.206 54.398a1 1 0 0 0 1.588 0z"></path><circle cx="38" cy="39" r="10" fill="currentColor"></circle></g></svg> Oaxaca</span>
									</div>
								</div>
								<div className="m1 mt3 mb2">
									<div className="travel-popular-tilt-left mb1">
										<div className="relative travel-results-result">
											<a className="travel-results-result-link block relative" href="#">
												<amp-img class="block rounded" width="346" height="200" noloading="" src={ travel_globals.theme_url + "/img/skateboard-around-city.jpg" } srcset={ travel_globals.theme_url + "/img/skateboard-around-city@2x.jpg 2x, " + travel_globals.theme_url + "/img/skateboard-around-city.jpg 1x" }></amp-img>
											</a>
											<div className="travel-results-result-like absolute top-0 right-0">
												<div className="p1">
													<label className="travel-like">
														<input type="checkbox" className="absolute"/>
															<div className="travel-like-hearts circle inline-block relative">
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart-tiny travel-like-heart-solid absolute"></div>
																<div className="travel-like-heart travel-like-heart-white absolute mx-auto "></div>
																<div className="travel-like-heart travel-like-heart-solid absolute mx-auto "></div>
																<div className="travel-like-heart travel-like-heart-outline absolute mx-auto "></div>
															</div>
													</label>
												</div>
											</div>
										</div>
									</div>

									<div className="h2 line-height-2 mb1">
										<span className="travel-results-result-text">Skateboard Around the City</span>
										<span className="travel-results-result-subtext h3">•</span>
										<span className="travel-results-result-subtext h3">$&nbsp;</span><span className="black bold">92</span>
									</div>

									<div className="h4 line-height-2">
										<div className="inline-block relative mr1 h3 line-height-2">
											<div className="travel-results-result-stars green">★★★★★</div>
										</div>
										<span className="travel-results-result-subtext mr1">17 Reviews</span>
										<span className="travel-results-result-subtext"><svg className="travel-icon" viewBox="0 0 77 100"><g fill="none" fill-rule="evenodd"><path stroke="currentColor" stroke-width="7.5" d="M38.794 93.248C58.264 67.825 68 49.692 68 38.848 68 22.365 54.57 9 38 9S8 22.364 8 38.85c0 10.842 9.735 28.975 29.206 54.398a1 1 0 0 0 1.588 0z"></path><circle cx="38" cy="39" r="10" fill="currentColor"></circle></g></svg> Mexico City</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			);
		},
	},
);
