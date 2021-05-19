<template>
    <div>
        <header class="header about">
            <b-container>
                <b-row>
                    <b-col :md="3" :xl="3">
                        <img :src="Bongeh" width="262" height="359" alt="Bongeh" id="Bongeh" />
                    </b-col>
                    <b-col :md="6" :xl="6">
                        <h1 class="text-center">Who the devil are Two Angry Gamers?</h1>
                        <p>
                            In short, Two Angry Gamers are a full time gaming duo providing
                            entertainment to the masses via Twitch and YouTube
                        </p>
                        <p>
                            Having already been producing videos on the YouTube for some time, we
                            (Adam and Tommy) took the plunge in January 2014 to make our passion our
                            livelihood. The shifting landscape of the gaming industry opened up a
                            huge opportunity in the form of livestreaming allowing us to provide
                            hours of entertainment across all platforms and genres.
                        </p>
                        <p>
                            In the last two years we have presented exclusive content and interviews
                            on upcoming games on YouTube, streamed pre-release content for upcoming
                            games and DLCs giving our eggs live, unrehearsed and unbiased reactions
                        </p>
                    </b-col>
                    <b-col :md="3" :xl="3">
                        <img :src="Tommy" width="262" height="359" alt="Tommy" id="Tommy" />
                    </b-col>
                </b-row>
            </b-container>
        </header>
        <section class="content">
            <b-container>
                <b-row>
                    <b-col>
                        <h2>When and Where?</h2>
                        <p>
                            Whatever time of day it is, you can always enjoy a wealth of videos over
                            on our YouTube page or catch up on past broadcasts and stream highlights
                            over on twitch! However... we love interacting with our community as
                            much as possible! So check the schedule below and see if you can make it
                            to one of our live broadcasts, we&apos;d love to hear from you!
                        </p>
                        <h3>Streaming Schedule</h3>
                        <p>
                            Unless stated on social media, we are usually live on
                            <a
                                href="https://twitch.tv/twoangrygamerstv"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Twitch
                            </a>
                            during the times stated below, we often host bonus streams and extra
                            hours to stay in the know follow us on
                            <a
                                href="https://www.twitter.com/2angrygamers"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Twitter
                            </a>
                            .
                        </p>
                        <table id="stream_schedule" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th width="10%">Time</th>
                                    <th>Stream Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="isLoading" class="text-center table-info">
                                    <td colspan="3">Loading Schedule...</td>
                                </tr>
                                <tr v-else-if="hasError" class="text-center table-danger">
                                    <td colspan="3">Failed to retieve schedule.</td>
                                </tr>
                                <template v-else>
                                    <tr v-for="(event, index) in schedule" :key="`event${index}`">
                                        <th scorpe="row">{{ event.label }}</th>
                                        <td>{{ event.start }} - {{ event.end }}</td>
                                        <td v-html="event.description"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <p class="help-block">Times are displayed in UTC.</p>
                        <h3>What?</h3>
                        <p>
                            We are a variety gaming channel, we love all things gaming, if it&apos;s
                            a game (or sometimes not quite a game *cough*
                            <i>early access</i>
                            *cough*) we will play it. If it&apos;s fun we will play it again and if
                            it isn&apos;t we won&apos;t. If it&apos;s on console or PC; sometimes
                            even boardgames, we will play it. We both game on PC, Xbox, Playstation,
                            Wii and more. And that is what you will see from us.
                        </p>
                        <p>
                            Have a favourite game you want us to play? Suggest it on
                            <a
                                href="https://www.facebook.com/TwoAngryGamersTV"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Facebook
                            </a>
                            or
                            <a
                                href="https://www.twitter.com/2angrygamers"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Twitter
                            </a>
                            or come into the
                            <a
                                href="https://twitch.tv/twoangrygamerstv"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Twitch
                            </a>
                            chat and ask us live.
                        </p>
                        <h3>Why?</h3>
                        <p>
                            Of course playing video games for a job doesn&apos;t need much of an
                            explanation, but that is just part of what we do. Providing
                            entertainment and a community that can offer support, help and
                            friendship to gamers at large is hugely rewarding. Each and every one of
                            you is an Egg and we want you in our Omelette. Join us.
                            <img :src="TagEgg" width="28" height="28" alt="tagEgg" />
                        </p>
                    </b-col>
                </b-row>
            </b-container>
        </section>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import BongehImg from '../../images/bongeh.png'
import TommyImg from '../../images/tom.png'
import TagEggImg from '../../images/tagegg.png'

export default {
    name: 'About',
    layout: Layout,
    metaInfo() {
        return {
            title: 'About',
        }
    },
    data() {
        return {
            Bongeh: BongehImg,
            Tommy: TommyImg,
            TagEgg: TagEggImg,
            hasError: false,
            isLoading: true,
            schedule: [],
        }
    },
    mounted: function () {
        window.axios
            .get('/schedule')
            .then((response) => {
                let days = [
                    {
                        label: 'Sunday',
                        displayed: false,
                    },
                    {
                        label: 'Monday',
                        displayed: false,
                    },
                    {
                        label: 'Tuesday',
                        displayed: false,
                    },
                    {
                        label: 'Wednesday',
                        displayed: false,
                    },
                    {
                        label: 'Thursday',
                        displayed: false,
                    },
                    {
                        label: 'Friday',
                        displayed: false,
                    },
                    {
                        label: 'Saturday',
                        displayed: false,
                    },
                ]

                response.data.data.forEach((event) => {
                    const startDate = this.moment(event.start, 'DD/MM/YYYY HH:mm:ss')
                    const endDate = this.moment(event.end, 'DD/MM/YYYY HH:mm:ss')
                    const Day = startDate.day()

                    this.schedule.push({
                        label: !days[Day].displayed ? days[Day].label : '',
                        start: startDate.format('HH:mm'),
                        end: endDate.format('HH:mm'),
                        description: event.description,
                    })

                    if (!days[Day].displayed) {
                        days[Day].displayed = true
                    }
                })

                this.isLoading = false
                this.hasError = false
            })
            .catch(() => {
                this.hasError = true
                this.isLoading = false
            })
    },
}
</script>
