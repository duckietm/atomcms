<x-app-layout>
    @push('title', __('Badge Generator'))

    <div class="col-span-12">
        <x-content.content-card icon="hotel-icon" classes="border dark:border-gray-900">
            <x-slot:title>
                Badge Drawer
            </x-slot:title>

            <x-slot:under-title>
                {{ __('Draw your very own badge') }}
            </x-slot:under-title>

            <div class="px-2 text-sm dark:text-gray-200">
                <div x-data="badgeDrawer()" class="mt-4">
                    <div class="flex gap-8 items-start">
                        <div class="checkerboard" style="position: relative; width: 640px; height: 640px;">
                            <div id="guide" x-ref="guide"></div>
                            <canvas width="40" height="40" x-ref="canvas" style="width: 100%; height: 100%; border: 1px solid #ccc; image-rendering: pixelated; background: transparent;"></canvas>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="font-bold mb-2">Preview</h3>
                            <div class="checkerboard" style="width: 40px; height: 40px;">
                                <canvas width="40" height="40" x-ref="previewCanvas" style="border: 1px solid #ccc; image-rendering: pixelated; background: transparent;"></canvas>
                            </div>
                            <div class="flex gap-4 mt-4 items-center">
                                <div>
                                    <label>Choose Color</label>
                                    <div @click="$refs.colorInput.click()" class="w-16 h-16 cursor-pointer flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="grey" stroke-width="1" viewBox="0 0 16 16">
                                            <path d="M6.192 2.78c-.458-.677-.927-1.248-1.35-1.643a3 3 0 0 0-.71-.515c-.217-.104-.56-.205-.882-.02-.367.213-.427.63-.43.896-.003.304.064.664.173 1.044.196.687.556 1.528 1.035 2.402L.752 8.22c-.277.277-.269.656-.218.918.055.283.187.593.36.903.348.627.92 1.361 1.626 2.068.707.707 1.441 1.278 2.068 1.626.31.173.62.305.903.36.262.05.64.059.918-.218l5.615-5.615c.118.257.092.512.05.939-.03.292-.068.665-.073 1.176v.123h.003a1 1 0 0 0 1.993 0H14v-.057a1 1 0 0 0-.004-.117c-.055-1.25-.7-2.738-1.86-3.494a4 4 0 0 0-.211-.434c-.349-.626-.92-1.36-1.627-2.067S8.857 3.052 8.23 2.704c-.31-.172-.62-.304-.903-.36-.262-.05-.64-.058-.918.219zM4.16 1.867c.381.356.844.922 1.311 1.632l-.704.705c-.382-.727-.66-1.402-.813-1.938a3.3 3.3 0 0 1-.131-.673q.137.09.337.274m.394 3.965c.54.852 1.107 1.567 1.607 2.033a.5.5 0 1 0 .682-.732c-.453-.422-1.017-1.136-1.564-2.027l1.088-1.088q.081.181.183.365c.349.627.92 1.361 1.627 2.068.706.707 1.44 1.278 2.068 1.626q.183.103.365.183l-4.861 4.862-.068-.01c-.137-.027-.342-.104-.608-.252-.524-.292-1.186-.8-1.846-1.46s-1.168-1.32-1.46-1.846c-.147-.265-.225-.47-.251-.607l-.01-.068zm2.87-1.935a2.4 2.4 0 0 1-.241-.561c.135.033.324.11.562.241.524.292 1.186.8 1.846 1.46.45.45.83.901 1.118 1.31a3.5 3.5 0 0 0-1.066.091 11 11 0 0 1-.76-.694c-.66-.66-1.167-1.322-1.458-1.847z"/>
                                        </svg>
                                    </div>
                                    <input type="color" id="colorInput" x-ref="colorInput" x-model="color" style="display: none;">
                                </div>
                                <div>
                                    <div :style="'background-color: ' + color" class="w-16 h-16 border border-gray-300"></div>
                                </div>
                                <div>
                                    <h4 class="font-bold mb-1">Palette</h4>
                                    <div class="grid grid-cols-6 gap-1">
                                        <template x-for="col in colors">
                                            <div @click="color = col; eraseMode = false" :style="'background-color: ' + col" class="w-6 h-6 cursor-pointer border border-gray-300"></div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <label for="eraseToggle">Erase Mode: </label>
                                <input type="checkbox" id="eraseToggle" x-model="eraseMode">
                            </div>
                            <div class="mt-2">
                                <label for="toggleGuide">Show Grid: </label>
                                <input type="checkbox" id="toggleGuide" x-model="showGrid" checked>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 10px;" class="flex gap-4 justify-between">
                        <button type="button" @click="clearBoard" class="w-full rounded bg-red-600 hover:bg-red-700 text-white p-2 border-2 border-red-500 transition ease-in-out duration-150 font-semibold">Clear All</button>
                        <button type="button" @click="generateCanvas('download')" class="w-full rounded bg-[#eeb425] text-white p-2 border-2 border-yellow-400 transition ease-in-out duration-200 hover:bg-[#d49f1c] font-semibold"> {{ __('Download badge') }} </button>
                    </div>
                </div>
            </div>
        </x-content.content-card>
    </div>

    <script>
        function badgeDrawer() {
            return {
                color: '#000000',
                eraseMode: false,
                showGrid: true,
                isDrawing: false,
                cellSideCount: 40,
                colorHistory: {},
                drawingContext: null,
                previewContext: null,
                guide: null,
                canvas: null,
                previewCanvas: null,
                colors: [
                    '#000000', '#FFFFFF', '#808080', '#C0C0C0', '#FF0000', '#800000',
                    '#FFFF00', '#808000', '#00FF00', '#008000', '#00FFFF', '#008080',
                    '#0000FF', '#000080', '#FF00FF', '#800080', '#FF4500', '#FFA500',
                    '#FFD700', '#F0E68C', '#90EE90', '#98FB98', '#AFEEEE', '#ADD8E6',
                    '#87CEFA', '#6495ED', '#DDA0DD', '#EE82EE', '#A52A2A', '#D2691E',
                    '#CD853F', '#F4A460', '#FFC0CB', '#9370DB', '#228B22', '#20B2AA'
                ],

                init() {
                    this.canvas = this.$refs.canvas;
                    this.previewCanvas = this.$refs.previewCanvas;
                    this.guide = this.$refs.guide;
                    this.drawingContext = this.canvas.getContext('2d');
                    this.previewContext = this.previewCanvas.getContext('2d');

                    // Setup the guide grid
                    this.guide.style.width = `${this.canvas.clientWidth}px`;
                    this.guide.style.height = `${this.canvas.clientHeight}px`;
                    this.guide.style.gridTemplateColumns = `repeat(${this.cellSideCount}, 1fr)`;
                    this.guide.style.gridTemplateRows = `repeat(${this.cellSideCount}, 1fr)`;
                    [...Array(this.cellSideCount ** 2)].forEach(() => this.guide.insertAdjacentHTML('beforeend', '<div style="border: 1px solid #000;"></div>'));

                    // Watch for grid toggle
                    this.$watch('showGrid', (value) => {
                        this.guide.style.display = value ? 'grid' : 'none';
                    });

                    // Add event listeners
                    this.canvas.addEventListener('mousedown', this.handleMousedown.bind(this));
                    this.canvas.addEventListener('mousemove', this.handleMousemove.bind(this));
                    this.canvas.addEventListener('mouseup', () => { this.isDrawing = false; });
                    this.canvas.addEventListener('mouseleave', () => { this.isDrawing = false; });

                    // Initial preview update
                    this.updatePreview();
                },

                handleMousedown(e) {
                    if (e.button !== 0) return;

                    const canvasBoundingRect = this.canvas.getBoundingClientRect();
                    const scaleX = this.canvas.width / canvasBoundingRect.width;
                    const scaleY = this.canvas.height / canvasBoundingRect.height;
                    const x = (e.clientX - canvasBoundingRect.left) * scaleX;
                    const y = (e.clientY - canvasBoundingRect.top) * scaleY;
                    const cellX = Math.floor(x);
                    const cellY = Math.floor(y);
                    const currentColor = this.colorHistory[`${cellX}_${cellY}`];

                    if (e.ctrlKey) {
                        if (currentColor) {
                            this.color = currentColor;
                        }
                    } else {
                        this.paintCell(cellX, cellY);
                        this.isDrawing = true;
                    }
                },

                handleMousemove(e) {
                    if (!this.isDrawing) return;

                    const canvasBoundingRect = this.canvas.getBoundingClientRect();
                    const scaleX = this.canvas.width / canvasBoundingRect.width;
                    const scaleY = this.canvas.height / canvasBoundingRect.height;
                    const x = (e.clientX - canvasBoundingRect.left) * scaleX;
                    const y = (e.clientY - canvasBoundingRect.top) * scaleY;
                    const cellX = Math.floor(x);
                    const cellY = Math.floor(y);

                    this.paintCell(cellX, cellY);
                },

                paintCell(cellX, cellY) {
                    if (this.eraseMode) {
                        this.drawingContext.clearRect(cellX, cellY, 1, 1);
                        delete this.colorHistory[`${cellX}_${cellY}`];
                    } else {
                        this.drawingContext.fillStyle = this.color;
                        this.drawingContext.fillRect(cellX, cellY, 1, 1);
                        this.colorHistory[`${cellX}_${cellY}`] = this.color;
                    }
                    this.updatePreview();
                },

                clearBoard() {
                    if (!confirm('Clear the entire board?')) return;
                    this.drawingContext.clearRect(0, 0, this.canvas.width, this.canvas.height);
                    this.colorHistory = {};
                    this.updatePreview();
                },

                updatePreview() {
                    this.previewContext.clearRect(0, 0, this.previewCanvas.width, this.previewCanvas.height);
                    this.previewContext.drawImage(this.canvas, 0, 0);
                },

                generateCanvas(action) {
                    const dataURL = this.canvas.toDataURL('image/png');
                    this.downloadAsImage(dataURL);
                },

                downloadAsImage(dataURL) {
                    const a = document.createElement('a');
                    a.href = dataURL;
                    a.download = 'badge.png';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }
            }
        }
    </script>

    <style>
        #canvas {
            cursor: pointer;
        }
        #guide {
            display: grid;
            pointer-events: none;
            position: absolute;
            top: 0;
            left: 0;
            border: 1px solid #000;
        }
        .checkerboard {
            background-color: #fff;
            background-image: 
                linear-gradient(45deg, #eee 25%, transparent 25%), 
                linear-gradient(-45deg, #eee 25%, transparent 25%), 
                linear-gradient(45deg, transparent 75%, #eee 75%), 
                linear-gradient(-45deg, transparent 75%, #eee 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        }
        input[type="color"] {
            position: absolute;
            top: auto;
            left: auto;
            bottom: 0;
            right: 0;
            transform: translateY(100%);
        }
    </style>
</x-app-layout>