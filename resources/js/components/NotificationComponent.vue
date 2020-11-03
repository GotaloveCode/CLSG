<template>
    <li class="dropdown dropdown-notification nav-item">
        <a class="nav-link nav-link-label" href="#"
           data-toggle="dropdown">
            <i class="feather icon-bell"></i>
            <span
                class="badge badge-pill badge-danger badge-up" v-text="count"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
            <li class="dropdown-menu-header">
                <h6 class="dropdown-header m-0"><span
                    class="grey darken-2">Notifications</span><span
                    class="notification-tag badge badge-danger float-right m-0">{{ count }} New</span>
                </h6>
            </li>
            <li class="scrollable-container media-list" v-for="(notification,i) in notifications" :key="i">
                <div class="media">
                    <div class="media-left align-self-center"><i
                        class="feather icon-plus-square icon-bg-circle bg-cyan"></i>
                    </div>
                    <div class="media-body">
                        <a :href="notification.data.url">
                            <h6 class="media-heading" v-text="notification.data.title"></h6>
                            <p class="notification-text font-small-3 text-muted" v-text="notification.data.details"></p>
                        </a>
                        <small>
                            <time class="media-meta text-muted mr-4"
                                  :datetime="notification.created_at">{{ diffForHuman(notification.created_at) }}
                            </time>
                            <a href="#" @click.prevent="markAsRead(notification)">Mark as read</a>
                        </small>
                    </div>
                </div>
            </li>
            <li class="dropdown-menu-footer">
                <a class="dropdown-item text-muted text-center"
                   href="/notifications">Read all</a>
            </li>
        </ul>
    </li>
</template>

<script>
import moment from 'moment';

export default {
    name: "NotificationComponent",
    props: {
        messages: {required: false, type: Array},
        notificationsCount: {required: false, type: Number}
    },
    data() {
        return {
            notifications: [],
            count: 0,
        }
    },
    mounted() {
        if (this.messages.length){
            this.notifications = this.messages;
        }else{
            this.fetchNotifications();
        }
        if (this.notificationsCount) this.count = this.notificationsCount;
    },
    methods: {
        diffForHuman(date) {
            return moment(date).fromNow();
        },
        markAsRead(data) {
            axios.put('/notifications/' + data.id).then(() => {
                this.$toastr.s("Notification marked as read", "Success");
            });
            const i = this.notifications.map(item => item.id).indexOf(data.id);
            this.notifications.splice(i, 1);
        },
        fetchNotifications() {
            axios.get('/notifications?limit=4').then(response => {
                this.notifications = response.data.notifications;
                this.count = response.data.count;
            });
        }
    }
}
</script>
