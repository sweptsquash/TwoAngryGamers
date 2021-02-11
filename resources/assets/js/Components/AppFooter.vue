<template>
    <footer class="app--footer mt-auto">
        <b-container>
            <b-row>
                <b-col :sm="12" :md="4">
                    <h4>About Us</h4>
                    <p>
                        Hey there! We are the two angry gamers - TOMMYRAGE & Bongeh. We like games,
                        but they dont like us.
                    </p>
                    <p>
                        <inertia-link :href="route('about')" class="text-light">
                            Find Out More
                        </inertia-link>
                    </p>
                </b-col>
                <b-col :sm="12" :md="4"></b-col>
                <b-col :sm="12" :md="4">
                    <h4>Follow Us On</h4>
                    <ul class="social--icons">
                        <li>
                            <a
                                href="https://www.facebook.com/TwoAngryGamersTV"
                                target="_blank"
                                title="Facebook"
                                rel="noopener noreferrer"
                            >
                                <font-awesome-icon :icon="['fab', 'facebook-f']" />
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://www.instagram.com/Bong3h"
                                target="_blank"
                                title="Bong Instagram"
                                rel="noopener noreferrer"
                            >
                                <font-awesome-icon :icon="['fab', 'instagram']" />
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://www.instagram.com/TOMMYRAGE"
                                target="_blank"
                                title="Tommy Instagram"
                                rel="noopener noreferrer"
                            >
                                <font-awesome-icon :icon="['fab', 'instagram']" />
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://twitter.com/2AngryGamers"
                                target="_blank"
                                title="Twitter"
                                rel="noopener noreferrer"
                            >
                                <font-awesome-icon :icon="['fab', 'twitter']" />
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://www.youtube.com/twoangrygamerstv"
                                target="_blank"
                                title="YouTube"
                                rel="noopener noreferrer"
                            >
                                <font-awesome-icon :icon="['fab', 'youtube']" />
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://www.twitch.tv/twoangrygamerstv"
                                target="_blank"
                                title="Twitch"
                                rel="noopener noreferrer"
                            >
                                <font-awesome-icon :icon="['fab', 'twitch']" />
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://discord.gg/twoangrygamerstv"
                                target="_blank"
                                title="Discord"
                                rel="noopener noreferrer"
                            >
                                <font-awesome-icon :icon="['fab', 'discord']" />
                            </a>
                        </li>
                    </ul>
                </b-col>
            </b-row>
            <b-row class="app--footer__copyright">
                <b-col class="text-center">
                    <p>
                        &copy; {{ year }} Two Angry Gamers. All Content is copyright &copy; it's
                        respective copyright holders. All Rights Reserved.
                    </p>
                </b-col>
            </b-row>
        </b-container>
    </footer>
</template>

<script>
export default {
    name: 'AppFooter',
    data() {
        const now = new Date()

        return {
            year: now.getFullYear(),
        }
    },
}
</script>
