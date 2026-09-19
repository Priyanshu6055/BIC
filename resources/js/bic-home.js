import * as THREE from 'three';

const clamp = (value, minimum, maximum) => Math.max(minimum, Math.min(maximum, value));

const root = document.querySelector('.approved-site');
if (root) {
    const heroTrack = root.querySelector('.hero-track');
    const portal = root.querySelector('.portal');
    const portalScene = root.querySelector('.portal-scene');
    const heroGrid = root.querySelector('.hero-grid');
    const portalCopy = root.querySelector('.portal-copy');
    const continueLabel = root.querySelector('.continue');
    const header = root.querySelector('header');
    const progressBar = root.querySelector('.progress b');
    const canvas = root.querySelector('#hero-canvas');
    const factorStory = root.querySelector('.motion-story');
    const factorCards = [...root.querySelectorAll('.factor-card')];
    const factorDots = [...root.querySelectorAll('.factor-dots i')];
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let frame = 0;

    const updateScroll = () => {
        frame = 0;
        const rect = heroTrack.getBoundingClientRect();
        const total = Math.max(1, heroTrack.offsetHeight - window.innerHeight);
        const progress = clamp(-rect.top / total, 0, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const size = 88 + (Math.max(window.innerWidth, window.innerHeight) * 1.95 - 88) * eased;
        portal.style.width = `${size}px`;
        portal.style.height = `${size}px`;
        portal.style.transform = `translateX(-50%) rotate(${45 - 45 * eased}deg)`;
        const sceneProgress = clamp((progress - 0.17) / 0.25, 0, 1);
        portalScene.style.opacity = String(sceneProgress);
        portalScene.style.transform = `scale(${1.08 - 0.08 * clamp((progress - 0.17) / 0.83, 0, 1)})`;
        heroGrid.style.opacity = String(1 - clamp((progress - 0.3) / 0.22, 0, 1));
        heroGrid.style.transform = `translateY(${-52 * clamp(progress / 0.64, 0, 1)}px)`;
        canvas.style.opacity = String(1 - clamp((progress - 0.24) / 0.22, 0, 1));
        const copyProgress = clamp((progress - 0.53) / 0.27, 0, 1);
        if (portalCopy) {
            portalCopy.style.opacity = String(copyProgress);
            portalCopy.style.transform = `translateY(${26 - 26 * copyProgress}px)`;
        }
        continueLabel.style.opacity = String(clamp((progress - 0.72) / 0.17, 0, 1));
        header.classList.toggle('on-dark', progress > 0.36);
        const documentProgress = clamp(window.scrollY / Math.max(1, document.body.scrollHeight - window.innerHeight), 0, 1);
        progressBar.style.height = `${documentProgress * 100}%`;
        if (factorStory && factorCards.length) {
            const factorRect = factorStory.getBoundingClientRect();
            const factorTotal = Math.max(1, factorStory.offsetHeight - window.innerHeight);
            const factorProgress = clamp(-factorRect.top / factorTotal, 0, 0.9999);
            const active = Math.min(factorCards.length - 1, Math.floor(factorProgress * factorCards.length));
            factorCards.forEach((card, index) => {
                const isActive = index === active;
                card.style.opacity = isActive ? '1' : '0';
                card.style.transform = isActive ? 'translateY(0)' : `translateY(${index < active ? -28 : 28}px)`;
                card.style.pointerEvents = isActive ? 'auto' : 'none';
            });
            factorDots.forEach((dot, index) => dot.classList.toggle('active', index === active));
        }
    };
    const requestUpdate = () => { if (!frame) frame = window.requestAnimationFrame(updateScroll); };
    const revealObserver = new IntersectionObserver((entries) => entries.forEach((entry) => {
        if (entry.isIntersecting) entry.target.classList.add('show');
    }), {threshold: 0.13});
    root.querySelectorAll('.reveal').forEach((element) => revealObserver.observe(element));

    if (!reducedMotion) {
        const probe = document.createElement('canvas');
        const webglAvailable = Boolean(probe.getContext('webgl2') ?? probe.getContext('webgl'));
        if (!webglAvailable) canvas.style.display = 'none';
        if (webglAvailable) {
            const renderer = new THREE.WebGLRenderer({canvas, antialias: true, alpha: true});
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.7));
            renderer.outputColorSpace = THREE.SRGBColorSpace;
            const scene = new THREE.Scene();
            scene.fog = new THREE.FogExp2(0x07101c, 0.035);
            const camera = new THREE.PerspectiveCamera(42, 1, 0.1, 100);
            camera.position.set(0, 0.25, 8.6);
            const group = new THREE.Group(); scene.add(group);
            const styles = getComputedStyle(document.documentElement);
            const primary = new THREE.Color(styles.getPropertyValue('--primary').trim());
            const primaryTwo = new THREE.Color(styles.getPropertyValue('--primary-2').trim());
            const accent = new THREE.Color(styles.getPropertyValue('--accent').trim());
            const deep = new THREE.Color(styles.getPropertyValue('--deep').trim());
            const coreMaterial = new THREE.MeshStandardMaterial({color: deep, metalness: 0.58, roughness: 0.32, emissive: primary, emissiveIntensity: 0.1});
            const nodeMaterial = new THREE.MeshStandardMaterial({color: primary, metalness: 0.42, roughness: 0.38});
            const goldMaterial = new THREE.MeshStandardMaterial({color: accent, metalness: 0.82, roughness: 0.2});
            const core = new THREE.Mesh(new THREE.IcosahedronGeometry(0.72, 4), coreMaterial); core.position.x = 0.85; group.add(core);
            const positions = [[-2.45,1.35,.15],[-.85,2.15,-.45],[1.05,2,.15],[2.7,1.15,-.35],[-2.7,-.65,-.2],[-1.15,-1.7,.35],[1.1,-1.75,-.15],[2.65,-.75,.25]];
            positions.forEach((position, index) => {
                const geometry = index % 3 === 0 ? new THREE.OctahedronGeometry(0.24) : new THREE.SphereGeometry(0.2, 24, 24);
                const node = new THREE.Mesh(geometry, index % 2 ? nodeMaterial : goldMaterial);
                node.position.set(position[0] + 0.85, position[1], position[2]); group.add(node);
                const curve = new THREE.QuadraticBezierCurve3(node.position.clone(), new THREE.Vector3((node.position.x + 0.85) * 0.48, node.position.y * 0.38, 0.65 + (index % 2) * -0.45), core.position.clone());
                group.add(new THREE.Mesh(new THREE.TubeGeometry(curve, 42, 0.012, 8, false), new THREE.MeshBasicMaterial({color: index % 2 ? primary : accent, transparent: true, opacity: 0.68})));
            });
            const halo = new THREE.Mesh(new THREE.TorusGeometry(1.15, 0.012, 10, 180), new THREE.MeshBasicMaterial({color: accent, transparent: true, opacity: 0.42}));
            halo.position.x = 0.85; halo.rotation.x = Math.PI / 2; group.add(halo);
            const particlePositions = [];
            for (let index = 0; index < 320; index += 1) particlePositions.push((Math.random() - .5) * 7 + 1, (Math.random() - .5) * 5, (Math.random() - .5) * 3);
            const particlesGeometry = new THREE.BufferGeometry(); particlesGeometry.setAttribute('position', new THREE.Float32BufferAttribute(particlePositions, 3));
            group.add(new THREE.Points(particlesGeometry, new THREE.PointsMaterial({color: primaryTwo, size: 0.018, transparent: true, opacity: 0.55})));
            scene.add(new THREE.HemisphereLight(0xffffff, 0x07101c, 0.9));
            const keyLight = new THREE.PointLight(accent, 6, 22); keyLight.position.set(3.5, 4, 4.5); scene.add(keyLight);
            const rimLight = new THREE.PointLight(primaryTwo, 4, 18); rimLight.position.set(-4, 1, -3); scene.add(rimLight);
            let pointerX = 0, pointerY = 0, running = true;
            const clock = new THREE.Clock();
            const resize = () => { const bounds = canvas.getBoundingClientRect(); renderer.setSize(bounds.width, bounds.height, false); camera.aspect = bounds.width / Math.max(1, bounds.height); camera.updateProjectionMatrix(); };
            window.addEventListener('pointermove', (event) => { pointerX = event.clientX / window.innerWidth - .5; pointerY = event.clientY / window.innerHeight - .5; }, {passive: true});
            new IntersectionObserver((entries) => { running = entries[0]?.isIntersecting ?? true; }, {threshold: .02}).observe(heroTrack);
            const animate = () => { requestAnimationFrame(animate); if (!running) return; const time = clock.getElapsedTime(); group.rotation.y = Math.sin(time * .13) * .035; group.rotation.x = Math.sin(time * .09) * .012; camera.position.x += (pointerX * .22 - camera.position.x) * .025; camera.position.y += (.6 - pointerY * .12 - camera.position.y) * .025; keyLight.position.x = 3.5 + Math.sin(time * .25) * 1.1; renderer.render(scene, camera); };
            window.addEventListener('resize', resize); resize(); animate();
        }
    }
    window.addEventListener('scroll', requestUpdate, {passive: true});
    window.addEventListener('resize', requestUpdate);
    updateScroll();
}

