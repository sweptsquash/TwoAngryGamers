<template>
    <div>
        <header class="header" :style="`background-image: url(${Banner});`">
            <b-container class="my-5">
                <b-row>
                    <b-col class="text-center">
                        <h1>Subperks</h1>
                    </b-col>
                </b-row>
            </b-container>
        </header>
        <section class="content">
            <b-container>
                <b-row>
                    <b-col>
                        <template v-if="!getUser.isSubscribed">
                            <h2>The Perks of being an Egg!</h2>
                            <p>
                                If your seeing this page you&apos;re either not logged in or you are
                                not subscribed to our Twitch channel.
                            </p>
                            <p>
                                Subscribing to us on Twitch not only supports us financially so that
                                we can keep providing that quality comedy entertainment that you
                                love, but there is a growing plethora of perks available to you as
                                well!
                            </p>
                            <p>
                                Currently we have several features available with a whole lot more
                                on the way.
                            </p>
                            <h2>Teamspeak Server</h2>
                            <p>
                                Once subbed to the twitch channel, log into this site and the
                                teamspeak details will be revealed to you! This server is often used
                                by us on Sub Sundays, the stream where we play games with you guys,
                                it’s also a great place to get to know other eggs and find people to
                                squad up with on various games.
                            </p>
                            <h2>
                                Good Samariteggs Corner
                                <small>(Coming Soon™)</small>
                            </h2>
                            <p>
                                Got a cd key or beta code spare? Bored and looking for something new
                                to while away the hours? This section of the website will allow eggs
                                to gift and receive codes and keys for games on all platforms,
                                spreading joy and generosity across all of the egg kingdom.
                            </p>
                            <h2>
                                Looking for Egg
                                <small>(Coming Soon™)</small>
                            </h2>
                            <p>
                                You’ve just bought the newest HOT game for whatever your preferred
                                platform is, you need some people with a similar sense of humour to
                                join up with in order to forge a yolky path to victory. This perk
                                will allow you to do just that, essentially listing your platforms
                                and games and connecting you with eggs who share those titles.
                            </p>
                            <p>
                                The perks listed will by no means end here, this is just what we
                                have planned for the near future, many more delights are to come.
                            </p>
                            <p>
                                Join the Omelette today to reap the benefits and become part of the
                                best community on Twitch.
                            </p>
                        </template>
                        <template v-else>
                            <div class="panel panel-primary">
                                <div class="panel-heading">The Perks of being an Egg!</div>
                                <div class="panel-body">
                                    <p>
                                        Subscribing to us on Twitch not only supports us financially
                                        so that we can keep providing that quality comedy
                                        entertainment that you love, but there is a growing plethora
                                        of perks available to you as well!
                                    </p>
                                    <p>
                                        Currently we have several features available with a whole
                                        lot more on the way.
                                    </p>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <a href="#teamspeak">Teamspeak Server</a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#samariteggs">Good Samariteggs Corner</a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#egg">Looking for Egg</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel panel-primary">
                                <div class="panel-heading" id="teamspeak">Teamspeak Server</div>
                                <div class="panel-body">
                                    <p>
                                        As a subscriber to our Twitch channel you have exclusive
                                        access to our teamspeak server.
                                    </p>
                                    <p>
                                        This is exclusively for people who have subbed to TAG
                                        it&apos;s a way for us to thank you for your support, and
                                        give our amazing community a place to hang out.
                                    </p>
                                    <p>
                                        Please do not give out any of the details for the server. If
                                        another sub asks how to get access, simply point them toward
                                        this page.
                                    </p>
                                    <div class="well">
                                        <p>
                                            TAG Sub Teamspeak
                                            <br />
                                            Address: 85.236.100.96:10427
                                            <br />
                                            Password: eggisreal
                                        </p>
                                        <a
                                            :href="`ts3server://85.236.100.96?port=10427&nickname=${getUser.name}&password=eggisreal&addbookmark=The Egg Teamspeak`"
                                            targe="_blank"
                                            rel="noreferrer noopener"
                                            style="width: 100%"
                                            class="btn btn-primary"
                                        >
                                            Connect
                                        </a>
                                    </div>
                                    <p>
                                        If you&apos;ve never used teamspeak before, don&apos;t
                                        worry! Lots of people haven&apos;t. Below is how to get it,
                                        connect to our server and a few notes on etiquette.
                                    </p>
                                    <h4>Install &amp; Setup Teamspeak</h4>
                                    <p>
                                        Grab the client from
                                        <a
                                            href="https://www.teamspeak.com/downloads"
                                            targe="_blank"
                                            rel="noreferrer noopener"
                                        >
                                            the teamspeak website
                                        </a>
                                        and install it.
                                    </p>
                                    <p class="text-center">
                                        <img style="max-width: 100%" :src="TSSetup" />
                                    </p>
                                    <p>
                                        If it doesn&apos;t prompt you to do so already, go to
                                        Settings in the menu bar and run the Setup Wizard to
                                        configure your settings. Please check out the next section
                                        for some advice regarding Push-To-Talk.
                                    </p>
                                    <h4>Etiquette</h4>
                                    <p>
                                        The teamspeak can get pretty busy sometimes, and there can
                                        often be a lot of people all within the same room. If you
                                        have a lot of background noise in your room (TV, family,
                                        dogs, etc) please use push to talk. Continuous transmission
                                        or voice activation detection can cause a lot of unnecessary
                                        noise which will irritate the other people in the channel
                                        trying to concentrate on something besides your pack of
                                        hounds brawling in the background.
                                    </p>
                                    <p class="text-center">
                                        <img style="max-width: 100%" :src="TSWizard" />
                                    </p>
                                    <p>
                                        These settings can be adjusted during the setup wizard, or
                                        afterwards in the Capture section of the teamspeak settings.
                                    </p>
                                    <p class="text-center">
                                        <img style="max-width: 100%" :src="TSSettings" />
                                    </p>
                                    <p>
                                        Just select Push-To-Talk, set a key and away you go. Any of
                                        the extra mouse buttons (middle mouse &amp; side buttons)
                                        are often nice buttons to choose from since there&apos;s not
                                        usually much conflict with games by default
                                    </p>
                                    <h4>Connecting to the Server</h4>
                                    <p>
                                        To connect to and bookmark the server, just
                                        <a
                                            :href="`ts3server://85.236.100.96?port=10427&nickname=${getUser.name}&password=eggisreal&addbookmark=The Egg Teamspeak`"
                                            targe="_blank"
                                            rel="noreferrer noopener"
                                        >
                                            click here
                                        </a>
                                        and bookmark the server.
                                    </p>
                                    <p>
                                        Now when you open teamspeak, you can click bookmarks and
                                        select The Egg Teamspeak from the dropdown to connect.
                                    </p>
                                    <p><i>See you there!</i></p>
                                </div>
                            </div>

                            <div class="panel panel-primary">
                                <div class="panel-heading" id="samariteggs">
                                    Good Samariteggs Corner
                                </div>
                                <div class="panel-body">
                                    <p class="text-center lead">Soon™</p>
                                    <p>
                                        Got a cd key or beta code spare? Bored and looking for
                                        something new to while away the hours? This section of the
                                        website will allow eggs to gift and receive codes and keys
                                        for games on all platforms, spreading joy and generosity
                                        across all of the egg kingdom.
                                    </p>
                                </div>
                            </div>

                            <div class="panel panel-primary">
                                <div class="panel-heading" id="egg">Looking for Egg</div>
                                <div class="panel-body">
                                    <p class="text-center lead">Soon™</p>
                                    <p>
                                        You’ve just bought the newest HOT game for whatever your
                                        preferred platform is, you need some people with a similar
                                        sense of humour to join up with in order to forge a yolky
                                        path to victory. This perk will allow you to do just that,
                                        essentially listing your platforms and games and connecting
                                        you with eggs who share those titles.
                                    </p>
                                </div>
                            </div>
                        </template>
                    </b-col>
                </b-row>
            </b-container>
        </section>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Layout from '@/Shared/Layout'
import BannerImg from '../../images/tagwindow_bg.png'
import TSSetupImg from '../../images/ts_setup.png'
import TSWizardImg from '../../images/ts_wizard_ptt.png'
import TSSettingsImg from '../../images/ts_settings_ptt.png'

export default {
    name: 'SubPerks',
    layout: Layout,
    metaInfo() {
        return {
            title: 'Sub Perks',
        }
    },
    data() {
        return {
            Banner: BannerImg,
            TSSetup: TSSetupImg,
            TSWizard: TSWizardImg,
            TSSettings: TSSettingsImg,
        }
    },
    computed: {
        ...mapGetters(['isAuthorized', 'getUser']),
    },
}
</script>
