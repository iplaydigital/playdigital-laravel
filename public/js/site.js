/**
 * Play Digital Co., Ltd. — Classic Frontend Interactions
 * - Mobile Burger Menu (.dl-menuwrapper) & Work Submenu Toggle
 * - Desktop Work Dropdown keyboard accessibility
 * - YouTube Showreel Hero Mute/Unmute & Lightbox Modal
 * - Progressive AJAX Contact Form Enhancement (with graceful Laravel fallback)
 */
document.addEventListener('DOMContentLoaded', function () {
    // 1. Mobile Burger Menu
    const burgerBtn = document.querySelector('[data-burger-trigger]');
    const burgerMenu = document.querySelector('[data-burger-menu]');
    const mobileWorkToggle = document.querySelector('[data-mobile-work-toggle]');

    if (burgerBtn && burgerMenu) {
        burgerBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = burgerMenu.classList.toggle('dl-menuopen');
            burgerBtn.classList.toggle('dl-active', isOpen);
            burgerBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        document.addEventListener('click', function (e) {
            if (!burgerMenu.contains(e.target) && e.target !== burgerBtn) {
                burgerMenu.classList.remove('dl-menuopen');
                burgerBtn.classList.remove('dl-active');
                burgerBtn.setAttribute('aria-expanded', 'false');
            }
        });

        burgerMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                burgerMenu.classList.remove('dl-menuopen');
                burgerBtn.classList.remove('dl-active');
                burgerBtn.setAttribute('aria-expanded', 'false');
            });
        });
    }

    if (mobileWorkToggle) {
        mobileWorkToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const parentLi = mobileWorkToggle.closest('li');
            if (parentLi) {
                const open = parentLi.classList.toggle('sub-open');
                mobileWorkToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            }
        });
    }

    // 2. Video Lightbox Modal (for Hero Showreel & Work Detail Videos)
    const modal = document.getElementById('videoLightboxModal');
    const modalFrame = document.getElementById('videoLightboxFrame');
    const modalClose = document.getElementById('videoLightboxClose');

    function openVideoModal(youtubeId) {
        if (!modal || !modalFrame || !youtubeId) return;
        modalFrame.src = 'https://www.youtube.com/embed/' + encodeURIComponent(youtubeId) + '?autoplay=1&rel=0&playsinline=1';
        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeVideoModal() {
        if (!modal || !modalFrame) return;
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');
        modalFrame.src = '';
    }

    document.querySelectorAll('[data-open-youtube]').forEach(function (trigger) {
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            openVideoModal(trigger.getAttribute('data-open-youtube'));
        });
    });

    if (modalClose) {
        modalClose.addEventListener('click', closeVideoModal);
    }

    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeVideoModal();
            }
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeVideoModal();
        }
    });

    // 3. Hero Background YouTube IFrame API (Mute / Unmute toggle + Ready fade-in)
    const heroPlayerContainer = document.getElementById('heroYoutubePlayer');
    const heroAspect = document.querySelector('.heroVideoAspect');
    const muteBtn = document.getElementById('heroMuteToggle');

    if (heroPlayerContainer) {
        const videoId = heroPlayerContainer.getAttribute('data-video-id');
        let ytPlayer = null;
        let isMuted = true;

        window.onYouTubeIframeAPIReady = function () {
            if (!window.YT || !window.YT.Player) return;
            ytPlayer = new window.YT.Player('heroYoutubePlayer', {
                videoId: videoId,
                playerVars: {
                    autoplay: 1,
                    mute: 1,
                    controls: 0,
                    loop: 1,
                    playlist: videoId,
                    playsinline: 1,
                    rel: 0,
                    modestbranding: 1
                },
                events: {
                    onReady: function (event) {
                        event.target.mute();
                        event.target.playVideo();
                        if (heroAspect) heroAspect.classList.add('video-ready');
                    },
                    onStateChange: function (event) {
                        if (event.data === window.YT.PlayerState.PLAYING && heroAspect) {
                            heroAspect.classList.add('video-ready');
                        }
                        if (event.data === window.YT.PlayerState.ENDED) {
                            event.target.playVideo();
                        }
                    }
                }
            });
        };

        const tag = document.createElement('script');
        tag.src = 'https://www.youtube.com/iframe_api';
        tag.async = true;
        document.head.appendChild(tag);

        if (muteBtn) {
            muteBtn.addEventListener('click', function () {
                if (!ytPlayer || typeof ytPlayer.isMuted !== 'function') {
                    openVideoModal(videoId);
                    return;
                }
                if (isMuted) {
                    ytPlayer.unMute();
                    ytPlayer.setVolume(80);
                    isMuted = false;
                    muteBtn.textContent = '🔊 Mute Sound';
                } else {
                    ytPlayer.mute();
                    isMuted = true;
                    muteBtn.textContent = '🔇 Unmute Sound';
                }
            });
        }
    }

    // 4. Progressive Enhancement for Contact Inquiry Forms
    document.querySelectorAll('[data-contact-form]').forEach(function (form) {
        form.addEventListener('submit', async function (e) {
            if (!window.fetch) return;
            e.preventDefault();

            const submitBtn = form.querySelector('button[type="submit"]');
            const feedbackBox = form.querySelector('[data-form-feedback]');
            const origLabel = submitBtn ? submitBtn.textContent : '';

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'กำลังส่งข้อความ...';
            }
            if (feedbackBox) {
                feedbackBox.innerHTML = '';
            }

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(form)
                });

                const data = await response.json();

                if (response.ok) {
                    form.reset();
                    if (feedbackBox) {
                        const box = document.createElement('div');
                        box.className = 'alertSuccess';
                        box.textContent = data.message || 'ส่งข้อมูลเรียบร้อยแล้ว';
                        feedbackBox.appendChild(box);
                    }
                } else {
                    const errors = data.errors ? Object.values(data.errors).flat() : [data.message || 'กรุณาตรวจสอบข้อมูลอีกครั้ง'];
                    if (feedbackBox) {
                        const box = document.createElement('div');
                        box.className = 'alertError';
                        box.innerHTML = errors.map(function (err) {
                            const span = document.createElement('div');
                            span.textContent = '• ' + err;
                            return span.outerHTML;
                        }).join('');
                        feedbackBox.appendChild(box);
                    }
                }
            } catch (_err) {
                // Fallback to native form submission if network/fetch fails
                form.submit();
                return;
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = origLabel;
                }
            }
        });
    });
});
